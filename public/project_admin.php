<?php
require_once '../includes/db.php';
include '../includes/header.php';

$project_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

// Verifica che l'utente sia il founder
$check = $db->prepare("SELECT membership_type FROM project_members WHERE project_id = ? AND user_id = ? AND membership_type = 'founder'");
$check->bind_param("ii", $project_id, $user_id);
$check->execute();
if (!$check->get_result()->fetch_assoc())
    die("Accesso negato. Solo il founder può gestire il progetto.");

// Recupera i membri attuali
$members_sql = $db->prepare("SELECT u.username, pm.membership_type, pm.user_id 
                             FROM project_members pm 
                             JOIN users u ON pm.user_id = u.id 
                             WHERE pm.project_id = ?");
$members_sql->bind_param("i", $project_id);
$members_sql->execute();
$members = $members_sql->get_result();
?>

<h2>Gestione Progetto</h2>
<h3>Membri del Team</h3>
<ul>
    <?php while ($m = $members->fetch_assoc()): ?>
        <li>
            <?= htmlspecialchars($m['username']) ?> (<?= $m['membership_type'] ?>)
            <?php if ($m['membership_type'] != 'founder'): ?>
                <button style="color: red;">Rimuovi</button>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
</ul>


<hr>
<h3>Aggiungi un Aggiornamento (News)</h3>
<form action="../actions/post_news.php" method="POST">
    <input type="hidden" name="project_id" value="<?= $project_id ?>">
    <textarea name="news_text" placeholder="Cosa è successo di nuovo?" required></textarea><br>
    <button type="submit">Pubblica Update</button>

    <hr>
    <h3>Gestione Ruoli Ricercati</h3>
    <form action="../actions/add_role.php" method="POST">
        <input type="hidden" name="project_id" value="<?= $project_id ?>">
        <input type="text" name="role_name" placeholder="Es. UX Designer" required>
        <button type="submit">Aggiungi Posizione</button>
    </form>

    <?php include '../includes/footer.php'; ?>