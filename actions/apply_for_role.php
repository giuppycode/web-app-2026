<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['project_id']) || !isset($data['role_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$project_id = intval($data['project_id']);
$role_id = intval($data['role_id']);

// 1. Check if user is already a member
$stmt = $db->prepare("SELECT 1 FROM project_members WHERE project_id = ? AND user_id = ?");
$stmt->bind_param("ii", $project_id, $user_id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You are already a member of this project']);
    exit;
}

// 2. Check if user has already applied for this project (any role) or specifically this role?
// Usually one application per project at a time is creating less spam, but let's check for this specific role first.
$stmt = $db->prepare("SELECT status FROM project_applications WHERE project_id = ? AND user_id = ? AND role_id = ? AND status = 'pending'");
$stmt->bind_param("iii", $project_id, $user_id, $role_id);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'You have already applied for this position']);
    exit;
}

// 3. Create Application
$stmt = $db->prepare("INSERT INTO project_applications (project_id, user_id, role_id) VALUES (?, ?, ?)");
$stmt->bind_param("iii", $project_id, $user_id, $role_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Application submitted successfully']);
} else {
    // If prepare/execute throws, we might not reach here, but if they return false (depending on implementation):
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
