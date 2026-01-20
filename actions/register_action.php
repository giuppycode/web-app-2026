<?php
session_start(); // Avviamo la sessione per loggare l'utente subito dopo la registrazione
require_once '../includes/db.php';

// Verifichiamo che la pagina sia stata chiamata via POST (clic sul bottone)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. RACCOLTA E PULIZIA DATI
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Qui gestiamo la BIOGRAPHY facoltativa.
    // Se l'utente ha scritto qualcosa la prendiamo, altrimenti salviamo una stringa vuota.
    $biography = isset($_POST['biography']) ? trim($_POST['biography']) : '';

    // Validazione base
    if (empty($username) || empty($email) || empty($password)) {
        die("Errore: Compila tutti i campi obbligatori.");
    }

    // 2. CONTROLLO SE L'UTENTE ESISTE GIÀ
    // Controlliamo sia username che email per evitare duplicati
    $checkQuery = "SELECT id FROM users WHERE email = ? OR username = ?";
    $stmt = $db->prepare($checkQuery);
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Se troviamo una riga, l'utente esiste già
        echo "<h3>Errore: Username o Email già utilizzati.</h3>";
        echo "<a href='../public/register.php'>Torna alla registrazione</a>";
        exit;
    }
    $stmt->close();

    // 3. SICUREZZA PASSWORD (HASHING)
    // Non salviamo mai la password in chiaro! Usiamo password_hash
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // 4. INSERIMENTO NEL DATABASE
    // Inseriamo anche la colonna 'biography'
    $sql = "INSERT INTO users (username, email, password, biography) VALUES (?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    
    if ($stmt) {
        // "ssss" significa: 4 parametri di tipo Stringa
        $stmt->bind_param("ssss", $username, $email, $password_hash, $biography);

        if ($stmt->execute()) {
            // REGISTRAZIONE AVVENUTA CON SUCCESSO
            
            // 5. LOGIN AUTOMATICO
            // Recuperiamo l'ID appena creato dal database
            $new_user_id = $stmt->insert_id;
            
            // Salviamo i dati nella sessione
            $_SESSION['user_id'] = $new_user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            // Reindirizziamo alla pagina Discovery (o al Profilo)
            header("Location: ../public/discovery.php");
            exit;
        } else {
            echo "Errore durante la registrazione: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Errore di connessione al database.";
    }

} else {
    // Se qualcuno prova ad aprire questa pagina direttamente senza passare dal form
    header("Location: ../public/register.php");
    exit;
}
?>