<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
require_once '../includes/ProjectValidation.php';
require_once '../includes/FileUploadHelper.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || $_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$project_id = intval($_POST['project_id'] ?? 0);

if (!$project_id) {
    $_SESSION['project_admin_error'] = "Invalid project ID.";
    header("Location: ../public/index.php");
    exit;
}

// Verify user is founder
if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    $_SESSION['project_admin_error'] = "Access denied. Only founders can edit the project.";
    header("Location: ../public/project.php?id=" . $project_id);
    exit;
}

try {
    // Retrieve and sanitize form data
    $name = trim($_POST['name'] ?? '');
    $intro = trim($_POST['intro'] ?? '');
    $description = trim($_POST['description'] ?? '');

    ProjectValidation::validateIntro($intro);
    ProjectValidation::validateDescription($description);
    ProjectValidation::validateProjectName($name);
    ProjectValidation::projectNameExists($db, $name);

    // Handle image upload (optional)
    $image_url = null;
    $update_image = false;

    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] === UPLOAD_ERR_OK) {
        $upload_result = FileUploadHelper::uploadProjectImage($_FILES['project_image']);

        if ($upload_result['success']) {
            $image_url = $upload_result['path'];
            $update_image = true;

            // Delete old image if it was a local upload
            $current_project = ProjectsHelper::getDetails($db, $project_id);
            if ($current_project && $current_project['image_url']) {
                FileUploadHelper::deleteProjectImage($current_project['image_url']);
            }
        } else {
            throw new Exception($upload_result['error']);
        }
    }

    // Update the project
    if ($update_image) {
        $stmt = $db->prepare("UPDATE projects SET name = ?, intro = ?, description = ?, image_url = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $name, $intro, $description, $image_url, $project_id);
    } else {
        $stmt = $db->prepare("UPDATE projects SET name = ?, intro = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $name, $intro, $description, $project_id);
    }

    if (!$stmt->execute()) {
        throw new Exception("Failed to update project.");
    }

    $stmt->close();

    // Success
    $_SESSION['project_admin_success'] = "Project updated successfully!";
    header("Location: ../public/project_admin.php?id=" . $project_id);
    exit;
} catch (Exception $e) {
    $_SESSION['project_admin_error'] = $e->getMessage();
    header("Location: ../public/project_admin.php?id=" . $project_id);
    exit;
}
