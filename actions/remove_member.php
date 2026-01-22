<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';

if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$project_id = intval($_POST['project_id'] ?? 0);
$member_user_id = intval($_POST['user_id'] ?? 0);

if (!$project_id || !$member_user_id) {
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

// Cannot remove founders
$stmt = $db->prepare("SELECT membership_type FROM project_members WHERE project_id = ? AND user_id = ?");
$stmt->bind_param("ii", $project_id, $member_user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['project_admin_error'] = "Member not found.";
    header("Location: ../public/project_admin.php?id=" . $project_id);
    exit;
}

$member = $result->fetch_assoc();
if ($member['membership_type'] === 'founder') {
    $_SESSION['project_admin_error'] = "Cannot remove founders.";
    header("Location: ../public/project_admin.php?id=" . $project_id);
    exit;
}

$stmt->close();

// Remove member
$stmt = $db->prepare("DELETE FROM project_members WHERE project_id = ? AND user_id = ?");
$stmt->bind_param("ii", $project_id, $member_user_id);

if ($stmt->execute()) {
    // Update occupied_slots
    $db->query("UPDATE projects SET occupied_slots = occupied_slots - 1 WHERE id = {$project_id}");
    
    $_SESSION['project_admin_success'] = "Member removed successfully.";
} else {
    $_SESSION['project_admin_error'] = "Failed to remove member.";
}

$stmt->close();
header("Location: ../public/project_admin.php?id=" . $project_id);
exit;