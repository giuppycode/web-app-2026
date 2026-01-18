<?php
require_once '../includes/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $uid = $_SESSION['user_id'];
    $name = $_POST['name'];
    $intro = $_POST['intro'];
    $desc = $_POST['description'];
    $slots = $_POST['total_slots'];

    // Inserisce il progetto
    $stmt = $db->prepare("INSERT INTO projects (name, intro, description, total_slots) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $name, $intro, $desc, $slots);
    $stmt->execute();
    $pid = $stmt->insert_id;

    // Assegna l'utente come Founder 
    $stmt_member = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type) VALUES (?, ?, 'founder')");
    $stmt_member->bind_param("ii", $pid, $uid);
    $stmt_member->execute();

    header("Location: ../public/project.php?id=" . $pid);
}
?>