<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

// Controllo input
$project_id = $_GET['id'] ?? 0;
if (!$project_id)
    die("ID progetto mancante.");

$user_id = $_SESSION['user_id'];

// 1. Verifica accesso (Logica nell'Helper)
if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    die("Accesso negato. Solo il founder può gestire il progetto.");
}

// 2. Recupero dati (Logica nell'Helper)
$members = ProjectsHelper::getMembers($db, $project_id);
// Opzionale: Recuperiamo anche i dettagli per mostrare il titolo
$project = ProjectsHelper::getDetails($db, $project_id);
?>

<h2>Gestione Progetto: <?= htmlspecialchars($project['name']) ?></h2>

<h3>Membri del Team</h3>
<ul>
    <?php while ($m = $members->fetch_assoc()): ?>
        <li>
            <?= htmlspecialchars($m['username']) ?>
            <span style="font-size: 0.8em; color: #666;">(<?= $m['membership_type'] ?>)</span>

            <?php if ($m['membership_type'] != 'founder'): ?>
                <button
                    style="color: red; border: 1px solid red; background: white; border-radius: 4px; padding: 2px 5px; cursor: pointer;">Rimuovi</button>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
</ul>

<hr>

<h3>Aggiungi un Aggiornamento (News)</h3>
<form action="../actions/post_news.php" method="POST">
    <input type="hidden" name="project_id" value="<?= $project_id ?>">
    <textarea name="news_text" placeholder="Cosa è successo di nuovo?" rows="3" required
        style="width: 100%; padding: 10px; margin-bottom: 10px;"></textarea>
    <button type="submit"
        style="background: var(--primary-green); color: white; border: none; padding: 8px 15px; border-radius: 5px;">Pubblica
        Update</button>
</form>
<hr>

<h3>Gestione Ruoli Ricercati</h3>
<form action="../actions/add_role.php" method="POST">
    <input type="hidden" name="project_id" value="<?= $project_id ?>">
    <input type="text" name="role_name" placeholder="Es. UX Designer" required
        style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
    <button type="submit"
        style="background: #333; color: white; border: none; padding: 8px 15px; border-radius: 5px;">Aggiungi
        Posizione</button>
</form>

<?php include '../includes/footer.php'; ?>