<?php
require_once '../includes/db.php';
include '../includes/header.php';

$sql = "SELECT n.*, p.name as project_name, u.username as author 
        FROM project_news n 
        JOIN projects p ON n.project_id = p.id 
        JOIN users u ON n.author_id = u.id 
        ORDER BY n.created_at DESC";
$news_res = $db->query($sql);
?>

<h1>Ultime dalle Idee in Sviluppo 📢</h1>
<p>Resta aggiornato sui progressi dei tuoi colleghi[cite: 9, 12].</p>

<?php while ($news = $news_res->fetch_assoc()): ?>
    <div class="project-card">
        <h4><?= htmlspecialchars($news['project_name']) ?></h4>
        <p><?= nl2br(htmlspecialchars($news['description'])) ?></p>
        <small>Pubblicato da: <strong><?= htmlspecialchars($news['author']) ?></strong> il
            <?= $news['created_at'] ?></small>
    </div>
<?php endwhile; ?>

<?php include '../includes/footer.php'; ?>