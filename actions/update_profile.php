<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    // Prendo la bio inviata o una stringa vuota se non c'è nulla
    $biography = isset($_POST['biography']) ? trim($_POST['biography']) : '';

    // Query di aggiornamento
    $stmt = $db->prepare("UPDATE users SET biography = ? WHERE id = ?");
    $stmt->bind_param("si", $biography, $user_id);

    if ($stmt->execute()) {
        // Successo: torno al profilo
        header("Location: ../public/profile.php?msg=updated");
    } else {
        // Errore
        echo "Errore durante l'aggiornamento: " . $db->error;
    }
} else {
    // Se provano ad accedere direttamente al file senza POST
    header("Location: ../public/profile.php");
}
?>