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

    $stmt = $db->prepare("INSERT INTO projects (name, intro, description, total_slots) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $intro, $desc, $slots);
    $stmt->execute();
    $pid = $stmt->insert_id;

    // set user as founder
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