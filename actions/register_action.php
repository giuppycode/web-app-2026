<?php
// actions/register_action.php

// 1. Configurazione Errori (utile per vedere se qualcosa si rompe nel backend)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';

// Avvio sessione
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifica Connessione
if (!isset($db)) {
    die("Errore Fatale: Variabile \$db non trovata in db.php.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- A. RECUPERO DATI DAL TUO NUOVO FORM ---
    $firstname = trim($_POST['firstname']);
    $lastname  = trim($_POST['lastname']);
    $faculty   = trim($_POST['faculty']);
    $number    = trim($_POST['number']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    // La biografia è opzionale, quindi controlliamo se esiste
    $biography = isset($_POST['biography']) ? trim($_POST['biography']) : '';

    // --- B. VALIDAZIONE ---
    // Controlliamo che i campi obbligatori non siano vuoti
    if (empty($firstname) || empty($lastname) || empty($faculty) || empty($number) || empty($username) || empty($email) || empty($password)) {
        $errorMsg = urlencode("Compila tutti i campi obbligatori.");
        header("Location: ../public/register.php?error=$errorMsg");
        exit;
    }

    try {
        // --- C. CONTROLLO DUPLICATI ---
        // Controlliamo se Email o Username esistono già
        $checkStmt = $db->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        if (!$checkStmt) {
            throw new Exception("Errore SQL Check: " . $db->error);
        }
        
        $checkStmt->bind_param("ss", $email, $username);
        $checkStmt->execute();
        
        if ($checkStmt->get_result()->num_rows > 0) {
            throw new Exception("Username o Email già registrati.");
        }
        $checkStmt->close();

        // --- D. INSERIMENTO NEL DB ---
        // Hash della password per sicurezza
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Query aggiornata con TUTTI i campi del tuo database
        $query = "INSERT INTO users (firstname, lastname, faculty, number, username, email, password, biography) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insertStmt = $db->prepare($query);
        if (!$insertStmt) {
            throw new Exception("Errore SQL Insert Prepare: " . $db->error);
        }

        // Bind dei parametri: 8 stringhe ("ssssssss")
        $insertStmt->bind_param("ssssssss", 
            $firstname, 
            $lastname, 
            $faculty, 
            $number, 
            $username, 
            $email, 
            $hashed_password, 
            $biography
        );

        if ($insertStmt->execute()) {
            // SUCCESSO!
            // Reindirizziamo al login con un messaggio
            $msg = urlencode("Registrazione completata! Ora puoi accedere.");
            header("Location: ../public/login.php?success=$msg"); 
            exit;
        } else {
            throw new Exception("Errore durante il salvataggio: " . $insertStmt->error);
        }

    } catch (Exception $e) {
        // ERRORE: Torniamo al form di registrazione con il messaggio di errore
        $errorMsg = urlencode($e->getMessage());
        header("Location: ../public/register.php?error=$errorMsg");
        exit;
    }

} else {
    // Se qualcuno prova ad aprire la pagina direttamente senza usare il form
    header("Location: ../public/register.php");
    exit;
}
?>