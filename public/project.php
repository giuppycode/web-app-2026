<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

$project_id = $_GET['id'] ?? 0;
$project = ProjectsHelper::getDetails($db, $project_id);

if (!$project)
    die("Progetto non trovato.");

$roles = ProjectsHelper::getRoles($db, $project_id);
?>

<h1><?= htmlspecialchars($project['name']) ?></h1>
<p><?= nl2br(htmlspecialchars($project['description'])) ?></p>

<hr>
<h3>Ruoli Disponibili</h3>
<ul>
    <?php while ($role = $roles->fetch_assoc()): ?>
        <li>
            <?= htmlspecialchars($role['role_name']) ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <button onclick="alert('Richiesta inviata!')">Candidati</button>
            <?php endif; ?>
        </li>
    <?php endwhile; ?>
</ul>

<?php include '../includes/footer.php'; ?>