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

    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc(); // Fetch the member data

        $stmt = $db->prepare("INSERT INTO project_news (project_id, author_id, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $project_id, $author_id, $description);
        $stmt->execute();

        // Redirect based on membership type
        if ($member['membership_type'] === 'founder') {
            header("Location: ../public/project_admin.php?id=" . $project_id);
        } else {
            header("Location: ../public/project_member.php?id=" . $project_id);
        }
    } else {
        // Fallback if not a member (shouldn't happen with UI checks)
        header("Location: ../public/index.php");
    }
} else {
    // Fallback for invalid request
    header("Location: ../public/index.php");
}
?>