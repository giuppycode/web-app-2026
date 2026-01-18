<?php
require_once '../includes/db.php';
include '../includes/header.php';
if (!isset($_SESSION['user_id']))
    header("Location: login.php");
?>

<h2>Lancia la tua Idea 🚀</h2>
<form action="../actions/create_project_action.php" method="POST">
    <label>Titolo del Progetto</label><br>
    <input type="text" name="name" placeholder="Es: CollabLearn" required><br><br>

    <label>Breve Introduzione</label><br>
    <input type="text" name="intro" maxlength="255" placeholder="Una frase che colpisca" required><br><br>

    <label>Descrizione Completa</label><br>
    <textarea name="description" rows="5" placeholder="Spiega la tua visione nel dettaglio" required></textarea><br><br>

    <label>Slot Totali (Membri necessari)</label><br>
    <input type="number" name="total_slots" value="2" min="1"><br><br>

    <button type="submit" style="background: #28a745; color: white; padding: 10px 20px; border: none; cursor: pointer;">
        Crea Progetto
    </button>
</form>
<?php include '../includes/footer.php'; ?>