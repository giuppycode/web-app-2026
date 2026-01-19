<?php
require_once '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id']))
    header("Location: login.php");

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<h2>Profilo di <?= htmlspecialchars($user['username']) ?></h2>
<section>
    <h3>La tua Bio</h3>
    <p><?= nl2br(htmlspecialchars($user['biography'] ?: 'Nessuna bio inserita.')) ?></p>
    
    <a href="edit_profile.php" style="display: inline-block; padding: 8px 16px; background-color: #eee; color: #333; text-decoration: none; border-radius: 5px; border: 1px solid #ccc;">
        ✏️ Modifica Info
    </a>
</section>

<section>
    <h3>Impostazioni Accessibilità [cite: 14]</h3>
    <label><input type="checkbox"> Modalità Dark Mode</label><br>
    <label><input type="checkbox"> Modalità Colorblind (WCAG 2.0)</label>
</section>

<hr>
<a href="create_project.php"
    style="padding: 10px; background: green; color: white; text-decoration: none; border-radius: 5px;">
    ➕ Crea Nuovo Progetto
</a>

<?php include '../includes/footer.php'; ?>