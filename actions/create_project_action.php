<?php
require_once '../includes/db.php';
require_once '../includes/ProjectValidation.php';
require_once '../includes/FileUploadHelper.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $name = trim($_POST['name'] ?? '');
    $intro = trim($_POST['intro'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $total_slots = intval($_POST['total_slots'] ?? 1);

    ProjectValidation::validateIntro($intro);
    ProjectValidation::validateDescription($description);
    ProjectValidation::validateTotalSlots($total_slots);
    ProjectValidation::validateProjectName($name);
    ProjectValidation::projectNameExists($db, $name);

    $image_url = null;
    
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
        $upload_result = FileUploadHelper::uploadProjectImage($_FILES['project_image']);
        
        if ($upload_result['success']) {
            $image_url = $upload_result['path'];
        } else {
            throw new Exception($upload_result['error']);
        }
    } else {
        // Fallback image if not provided
        $image_url = 'https://picsum.photos/400/200?' . time();
    }

    $stmt = $db->prepare("INSERT INTO projects (name, intro, description, image_url, total_slots, occupied_slots) VALUES (?, ?, ?, ?, ?, 1)");
    $stmt->bind_param("ssssi", $name, $intro, $description, $image_url, $total_slots);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to create project: " . $stmt->error);
    }
    
    $project_id = $stmt->insert_id;
    $stmt->close();

    // Assign the user as Founder
    $stmt_member = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type) VALUES (?, ?, 'founder')");
    $stmt_member->bind_param("ii", $project_id, $user_id);
    
    if (!$stmt_member->execute()) {
        throw new Exception("Failed to assign founder: " . $stmt_member->error);
    }
    
    $stmt_member->close();

    $_SESSION['create_project_success'] = "Project created successfully!";
    header("Location: ../public/project.php?id=" . $project_id);
    exit;

} catch (Exception $e) {
    $_SESSION['create_project_error'] = $e->getMessage();
    header("Location: ../public/create_project.php");
    exit;
}
?>