<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$project_id = intval($_POST['project_id'] ?? 0);
$role_id = intval($_POST['role_id'] ?? 0);

if (!$project_id || !$role_id) {
    $_SESSION['project_admin_error'] = "Invalid request.";
    header("Location: ../public/index.php");
    exit;
}

// Verify user is founder
if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    $_SESSION['project_admin_error'] = "Access denied.";
    header("Location: ../public/project.php?id=" . $project_id);
    exit;
}

// Delete role
$stmt = $db->prepare("DELETE FROM project_roles WHERE id = ? AND project_id = ?");
$stmt->bind_param("ii", $role_id, $project_id);

if ($stmt->execute()) {
    // Update total_slots (one less open position)
    $db->query("UPDATE projects SET total_slots = total_slots - 1 WHERE id = {$project_id}");
    
    $_SESSION['project_admin_success'] = "Role deleted successfully.";
} else {
    $_SESSION['project_admin_error'] = "Failed to delete role.";
}

$stmt->close();
header("Location: ../public/project_admin.php?id=" . $project_id);
exit;