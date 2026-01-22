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

    // Parse co-founders and roles from JSON
    $co_founders_json = $_POST['co_founders'] ?? '[]';
    $roles_json = $_POST['roles'] ?? '[]';
    $co_founders = json_decode($co_founders_json, true) ?? [];
    $roles = json_decode($roles_json, true) ?? [];
    
    // Calculate total slots: 1 (creator) + co-founders + roles
    $total_slots = 1 + count($co_founders) + count($roles);
    // Creator + co-founders
    $occupied_slots = 1 + count($co_founders); 

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

    // Begin transaction
    $db->query("START TRANSACTION");

    try {
        // Insert the project
        $stmt = $db->prepare("INSERT INTO projects (name, intro, description, image_url, total_slots, occupied_slots) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $name, $intro, $description, $image_url, $total_slots, $occupied_slots);
        
        if (!$stmt->execute()) {
            throw new Exception("Failed to create project: " . $stmt->error);
        }
        
        $project_id = $stmt->insert_id;
        $stmt->close();

        // Assign the creator as Founder
        $stmt_creator = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type) VALUES (?, ?, 'founder')");
        $stmt_creator->bind_param("ii", $project_id, $user_id);
        
        if (!$stmt_creator->execute()) {
            throw new Exception("Failed to assign creator as founder: " . $stmt_creator->error);
        }
        $stmt_creator->close();

        // Add co-founders as project members with 'founder' type
        if (!empty($co_founders)) {
            $stmt_cofounder = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type) VALUES (?, ?, 'founder')");
            
            foreach ($co_founders as $cofounder_id) {
                $cofounder_id = intval($cofounder_id);
                
                // Verify user exists
                $check_stmt = $db->prepare("SELECT id FROM users WHERE id = ?");
                $check_stmt->bind_param("i", $cofounder_id);
                $check_stmt->execute();
                $user_exists = $check_stmt->get_result()->num_rows > 0;
                $check_stmt->close();
                
                if (!$user_exists) {
                    throw new Exception("One or more selected co-founders do not exist.");
                }
                
                $stmt_cofounder->bind_param("ii", $project_id, $cofounder_id);
                if (!$stmt_cofounder->execute()) {
                    throw new Exception("Failed to add co-founder: " . $stmt_cofounder->error);
                }
            }
            $stmt_cofounder->close();
        }

        // Add roles as project_roles
        if (!empty($roles)) {
            $stmt_role = $db->prepare("INSERT INTO project_roles (project_id, role_name) VALUES (?, ?)");
            
            foreach ($roles as $role_name) {
                $role_name = trim($role_name);
                if (empty($role_name)) continue;
                
                $stmt_role->bind_param("is", $project_id, $role_name);
                if (!$stmt_role->execute()) {
                    throw new Exception("Failed to add role: " . $stmt_role->error);
                }
            }
            $stmt_role->close();
        }

        // Commit transaction
        $db->query("COMMIT");

        // Success - redirect to project page
        $_SESSION['create_project_success'] = "Project created successfully!";
        header("Location: ../public/project.php?id=" . $project_id);
        exit;

    } catch (Exception $e) {
        // Rollback on error
        $db->query("ROLLBACK");
        throw $e;
    }

} catch (Exception $e) {
    // Error handling
    $_SESSION['create_project_error'] = $e->getMessage();
    header("Location: ../public/create_project.php");
    exit;
}
?>