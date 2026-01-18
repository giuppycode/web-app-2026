<?php
require_once '../includes/db.php';

if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Controlla slot disponibili
    $proj = $db->query("SELECT occupied_slots, total_slots FROM projects WHERE id = $project_id")->fetch_assoc();

    // Controlla se è già membro
    $check = $db->query("SELECT * FROM project_members WHERE project_id = $project_id AND user_id = $user_id");

    if ($proj['occupied_slots'] < $proj['total_slots'] && $check->num_rows == 0) {
        // Inserisci membro
        $stmt = $db->prepare("INSERT INTO project_members (project_id, user_id, membership_type) VALUES (?, ?, 'member')");
        $stmt->bind_param("ii", $project_id, $user_id);
        $stmt->execute();

        // Aggiorna contatore slot
        $db->query("UPDATE projects SET occupied_slots = occupied_slots + 1 WHERE id = $project_id");
    }
}
header("Location: ../public/project.php?id=" . $project_id);
?>