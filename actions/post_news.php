<?php
require_once '../includes/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $project_id = $_POST['project_id'];
    $author_id = $_SESSION['user_id'];
    $description = $_POST['news_text'];

    // Verifica sicurezza: l'utente è membro del progetto?
    $check = $db->prepare("SELECT * FROM project_members WHERE project_id = ? AND user_id = ?");
    $check->bind_param("ii", $project_id, $author_id);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        $stmt = $db->prepare("INSERT INTO project_news (project_id, author_id, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $project_id, $author_id, $description);
        $stmt->execute();
    }
}

header("Location: ../public/project_admin.php?id=" . $project_id);
?>