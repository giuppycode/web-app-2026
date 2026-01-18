<?php
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $project_id = $_POST['project_id'];
    $role_name = $_POST['role_name'];

    // Verifica che l'utente sia il founder
    $check = $db->prepare("SELECT * FROM project_members WHERE project_id = ? AND user_id = ? AND membership_type = 'founder'");
    $check->bind_param("ii", $project_id, $_SESSION['user_id']);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $stmt = $db->prepare("INSERT INTO project_roles (project_id, role_name) VALUES (?, ?)");
        $stmt->bind_param("is", $project_id, $role_name);
        $stmt->execute();
    }
}
header("Location: ../public/project_admin.php?id=" . $project_id);
?>