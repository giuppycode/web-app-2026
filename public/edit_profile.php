<?php
require_once '../includes/db.php';
include '../includes/header.php';

// Controllo se l'utente è loggato
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Recupero i dati attuali dell'utente
$stmt = $db->prepare("SELECT biography FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<div class="container">
    <h2>Modifica il tuo Profilo</h2>
    
    <form action="../actions/update_profile.php" method="POST" style="max-width: 500px;">
        <div style="margin-bottom: 15px;">
            <label for="biography" style="display: block; font-weight: bold; margin-bottom: 5px;">Biografia:</label>
            <textarea name="biography" id="biography" rows="6" style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ccc;"><?= htmlspecialchars($user['biography']) ?></textarea>
            <small style="color: #666;">Scrivi qualcosa su di te, le tue competenze o cosa stai studiando.</small>
        </div>

        <button type="submit" style="padding: 10px 20px; background: #000; color: #fff; border: none; border-radius: 8px; cursor: pointer;">
            Salva Modifiche
        </button>
        
        <a href="profile.php" style="margin-left: 10px; text-decoration: underline; color: #333;">Annulla</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>