<?php
// Abilita la visualizzazione degli errori per il debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica il percorso corretto per db.php
$dbPath = __DIR__ . '/../includes/db.php';
if (!file_exists($dbPath)) {
    die("Errore: Impossibile trovare il file database in: $dbPath");
}
require_once $dbPath;

// Verifica sessione
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    // Se non sei loggato, vai al login
    header("Location: ../public/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("Errore: ID progetto mancante.");
}

$user_id = $_SESSION['user_id'];
$project_id = intval($_GET['id']);

try {
    // 1. Controlla se il like esiste già
    $check = $db->prepare("SELECT * FROM project_stars WHERE user_id = ? AND project_id = ?");
    if (!$check) {
        throw new Exception("Errore prepare check: " . $db->error);
    }
    $check->bind_param("ii", $user_id, $project_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        // Se esiste, rimuovilo (Unstar)
        $stmt = $db->prepare("DELETE FROM project_stars WHERE user_id = ? AND project_id = ?");
    } else {
        // Se non esiste, aggiungilo (Star)
        $stmt = $db->prepare("INSERT INTO project_stars (user_id, project_id) VALUES (?, ?)");
    }

    if (!$stmt) {
        throw new Exception("Errore prepare action: " . $db->error);
    }

    $stmt->bind_param("ii", $user_id, $project_id);
    $stmt->execute();

} catch (Exception $e) {
    die("Errore Database: " . $e->getMessage());
}

// REDIREZIONE SICURA
// Se HTTP_REFERER esiste, usalo. Altrimenti torna alla discovery.
$redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../public/discovery.php';

// Evita loop se referer è la pagina stessa (caso raro)
if (strpos($redirect, 'star_project.php') !== false) {
    $redirect = '../public/discovery.php';
}

header("Location: " . $redirect);
exit;
?>