<?php
require_once '../includes/db.php';
include '../includes/header.php';

// Recupero progetti con i relativi tag
$sql = "SELECT p.*, GROUP_CONCAT(t.name) as tags 
        FROM projects p 
        LEFT JOIN project_tags pt ON p.id = pt.project_id 
        LEFT JOIN tags t ON pt.tag_id = t.id 
        GROUP BY p.id ORDER BY p.created_at DESC";
$res = $db->query($sql);
?>

<h1>Esplora i Progetti del Campus</h1>
<p>Trova i tuoi futuri co-founder tra i tuoi compagni di università[cite: 2, 4].</p>

<div class="discovery-grid">
    <?php while ($p = $res->fetch_assoc()): ?>
        <div class="project-card">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p><em><?= htmlspecialchars($p['intro']) ?></em></p>
            <div>
                <?php if ($p['tags']):
                    foreach (explode(',', $p['tags']) as $tag): ?>
                        <span class="tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; endif; ?>
            </div>
            <p>Slot occupati: <?= $p['occupied_slots'] ?> / <?= $p['total_slots'] ?></p>
            <a href="project.php?id=<?= $p['id'] ?>">Visualizza Dettagli</a>
        </div>
    <?php endwhile; ?>
</div>

<?php include '../includes/footer.php'; ?>