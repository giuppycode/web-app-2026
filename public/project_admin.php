<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
require_once '../includes/ImageHelper.php';

// Project id must be provided
$project_id = $_GET['id'] ?? 0;
if (!$project_id) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? 0;

if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    header("Location: project.php?id=" . $project_id);
    exit;
}

$project = ProjectsHelper::getDetails($db, $project_id);
$members = ProjectsHelper::getMembers($db, $project_id);
$roles = ProjectsHelper::getRoles($db, $project_id);

$error = $_SESSION['project_admin_error'] ?? null;
$success = $_SESSION['project_admin_success'] ?? null;
unset($_SESSION['project_admin_error'], $_SESSION['project_admin_success']);

include '../includes/header.php';
?>

<script src="../assets/js/project_admin.js"></script>

<?php include '../includes/footer.php'; ?>