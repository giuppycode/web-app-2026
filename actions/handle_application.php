<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';

header('Content-Type: application/json');

session_start();
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$current_user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['application_id']) || !isset($data['action'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$application_id = intval($data['application_id']);
$action = $data['action']; // 'accept' or 'decline'

// Verify that the current user is a founder of the project associated with this application
$stmt = $db->prepare("SELECT pa.*, p.id as project_id 
                      FROM project_applications pa
                      JOIN projects p ON pa.project_id = p.id
                      JOIN project_members pm ON p.id = pm.project_id
                      WHERE pa.id = ? AND pm.user_id = ? AND pm.membership_type = 'founder'");
$stmt->bind_param("ii", $application_id, $current_user_id);
$stmt->execute();
$application = $stmt->get_result()->fetch_assoc();

if (!$application) {
    echo json_encode(['success' => false, 'message' => 'Application not found or permission denied']);
    exit;
}

if ($application['status'] !== 'pending') {
    echo json_encode(['success' => false, 'message' => 'Application already processed']);
    exit;
}

$project_id = $application['project_id'];
$applicant_id = $application['user_id'];
$role_id = $application['role_id'];

if ($action === 'accept') {
    // Start transaction
    $db->begin_transaction();
    try {
        // 1. Update application status
        $updateStmt = $db->prepare("UPDATE project_applications SET status = 'accepted' WHERE id = ?");
        $updateStmt->bind_param("i", $application_id);
        $updateStmt->execute();

        // 2. Add user to project members
        $insertStmt = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type, role_id) VALUES (?, ?, 'member', ?)");
        $insertStmt->bind_param("iii", $project_id, $applicant_id, $role_id);
        $insertStmt->execute();

        // 3. Increment occupied slots in project
        $updateProjectStmt = $db->prepare("UPDATE projects SET occupied_slots = occupied_slots + 1 WHERE id = ?");
        $updateProjectStmt->bind_param("i", $project_id);
        $updateProjectStmt->execute();

        $db->commit();
        echo json_encode(['success' => true, 'message' => 'Application accepted']);

    } catch (Exception $e) {
        $db->rollback();
        echo json_encode(['success' => false, 'message' => 'Error processing application: ' . $e->getMessage()]);
    }

} elseif ($action === 'decline') {
    // Just update status
    $stmt = $db->prepare("UPDATE project_applications SET status = 'rejected' WHERE id = ?");
    $stmt->bind_param("i", $application_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Application declined']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
