<?php
require_once '../includes/db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];

    // Recupera i dati dal form (usando i nomi degli input definiti in edit_profile.php)
    $firstname = trim($_POST['first_name'] ?? '');
    $lastname = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? ''); // Corrisponde a 'number' nel DB
    $faculty = trim($_POST['faculty'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $biography = trim($_POST['biography'] ?? '');

    // Validazione base
    if (empty($email)) {
        // Gestione errore semplice: torna indietro
        header("Location: ../public/edit_profile.php?error=empty_email");
        exit;
    }

    // Query di aggiornamento mappata sulle nuove colonne del DB
    $sql = "UPDATE users SET 
            firstname = ?, 
            lastname = ?, 
            email = ?, 
            number = ?, 
            faculty = ?, 
            username = ?,
            biography = ? 
            WHERE id = ?";

    $stmt = $db->prepare($sql);

    $stmt->bind_param("sssssssi", $firstname, $lastname, $email, $phone, $faculty, $username, $biography, $user_id);

    if ($stmt->execute()) {
        // Successo: torna al profilo
        header("Location: ../public/profile.php?success=profile_updated");
    } else {
        // Errore DB
        header("Location: ../public/edit_profile.php?error=db_error");
    }

    $stmt->close();
} else {
    // Se qualcuno prova ad aprire il file direttamente senza POST
    header("Location: ../public/profile.php");
}
?>