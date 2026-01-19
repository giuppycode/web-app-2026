<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php'; // Includiamo la classe Helper
include '../includes/header.php';

// Chiamata alla funzione helper invece della query diretta
$news_res = ProjectsHelper::getAllActivity($db);
?>

<h1>Ultime dalle Idee in Sviluppo 📢</h1>
<p>Resta aggiornato sui progressi dei tuoi colleghi.</p>

<?php while ($news = $news_res->fetch_assoc()): ?>
    <div class="project-card">
        <h4><?= htmlspecialchars($news['project_name']) ?></h4>
        <p><?= nl2br(htmlspecialchars($news['description'])) ?></p>
        <small>Pubblicato da: <strong><?= htmlspecialchars($news['author']) ?></strong> il
            <?= $news['created_at'] ?></small>
    </div>
<?php endwhile; ?>

<?php include '../includes/footer.php'; ?>