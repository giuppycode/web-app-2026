<?php
// actions/update_profile.php

// 1. ATTIVA DEBUG (Ti mostrerà l'errore esatto invece di pagina bianca)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Controllo Accesso
if (!isset($_SESSION['user_id']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Accesso negato. Devi essere loggato e inviare il form.");
}

$user_id = $_SESSION['user_id'];
$username = trim($_POST['username']);
$biography = trim($_POST['biography']);
$tags = isset($_POST['tags']) ? $_POST['tags'] : [];

// Verifica connessione DB
if (!$db) {
    die("Errore fatale: Connessione al database mancante.");
}

try {
    // ---------------------------------------------------
    // A. Controllo Username Duplicato
    // ---------------------------------------------------
    $checkStmt = $db->prepare("SELECT id FROM users WHERE username = ? AND id != ?");
    if (!$checkStmt) { throw new Exception("Errore SQL Check: " . $db->error); }
    
    $checkStmt->bind_param("si", $username, $user_id);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        throw new Exception("Questo username è già usato da un altro utente.");
    }
    $checkStmt->close();

    // ---------------------------------------------------
    // B. Aggiorna Dati Utente
    // ---------------------------------------------------
    $updStmt = $db->prepare("UPDATE users SET username = ?, biography = ? WHERE id = ?");
    if (!$updStmt) { throw new Exception("Errore SQL Update: " . $db->error); }

    $updStmt->bind_param("ssi", $username, $biography, $user_id);
    if (!$updStmt->execute()) {
        throw new Exception("Impossibile aggiornare utente: " . $updStmt->error);
    }
    $updStmt->close();

    // 1. Cancella vecchi tag
    $delStmt = $db->prepare("DELETE FROM user_tags WHERE user_id = ?");
    $delStmt->bind_param("i", $user_id);
    $delStmt->execute();
    $delStmt->close();

    // 2. Inserisci nuovi tag
    if (!empty($tags) && is_array($tags)) {
        $insStmt = $db->prepare("INSERT INTO user_tags (user_id, tag_id) VALUES (?, ?)");
        if (!$insStmt) { throw new Exception("Errore SQL Insert Tags: " . $db->error); }

        foreach ($tags as $tag_id) {
            $tid = intval($tag_id);
            $insStmt->bind_param("ii", $user_id, $tid);
            $insStmt->execute();
        }
        $insStmt->close();
    }

    // Aggiorna sessione
    $_SESSION['username'] = $username;

    // Successo
    header("Location: ../public/profile.php?msg=updated");
    exit;

} catch (Exception $e) {
    // IN CASO DI ERRORE: Lo mostriamo a schermo invece di reindirizzare
    // Così puoi leggere cosa non va
    echo "<div style='color:red; padding:20px; font-size:18px; border:2px solid red;'>";
    echo "<h1>ERRORE TROVATO:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='../public/edit_profile.php'>Torna indietro</a>";
    echo "</div>";
    exit;
}
?>