<?php
require_once '../includes/db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $bio = $_POST['biography'];

    try {
        $stmt = $db->prepare("INSERT INTO users (username, email, password, biography) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user, $email, $pass, $bio);
        $stmt->execute();
        header("Location: ../public/login.php?success=1");
    } catch (Exception $e) {
        die("Errore durante la registrazione: " . $e->getMessage());
    }
}
?>