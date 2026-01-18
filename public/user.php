<?php
require_once '../includes/db.php';
include '../includes/header.php';

$target_id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT username, biography, email FROM users WHERE id = ?");
$stmt->bind_param("i", $target_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user)
    die("Utente non trovato.");

// Recupera i progetti a cui partecipa
$projs = $db->prepare("SELECT p.id, p.name, pm.membership_type FROM projects p 
                       JOIN project_members pm ON p.id = pm.project_id 
                       WHERE pm.user_id = ?");
$projs->bind_param("i", $target_id);
$projs->execute();
$projects_res = $projs->get_result();
?>

<div class="card">
    <h1>Profilo di
        <?= htmlspecialchars($user['username']) ?>
    </h1>
    <p><em>
            <?= htmlspecialchars($user['email']) ?>
        </em></p>
    <hr>
    <h3>Bio</h3>
    <p>
        <?= nl2br(htmlspecialchars($user['biography'])) ?>
    </p>
</div>

<h3>Progetti Attivi</h3>
<ul>
    <?php while ($p = $projects_res->fetch_assoc()): ?>
        <li>
            <a href="project.php?id=<?= $p['id'] ?>">
                <?= htmlspecialchars($p['name']) ?>
            </a>
            <span class="tag">
                <?= $p['membership_type'] ?>
            </span>
        </li>
    <?php endwhile; ?>
</ul>

<?php include '../includes/footer.php'; ?>