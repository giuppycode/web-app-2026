<?php
require_once '../includes/db.php';
include '../includes/header.php';

$project_id = $_GET['id'] ?? 0;
$stmt = $db->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);
$stmt->execute();
$project = $stmt->get_result()->fetch_assoc();

if (!$project)
    die("Progetto non trovato.");

// Recupera i ruoli
$roles_stmt = $db->prepare("SELECT * FROM project_roles WHERE project_id = ?");
$roles_stmt->bind_param("i", $project_id);
$roles_stmt->execute();
$roles = $roles_stmt->get_result();
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

<h3>News del Progetto</h3>
<?php include '../includes/footer.php'; ?>