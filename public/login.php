<?php 
require_once '../includes/db.php';
include '../includes/header.php'; 
?>

<div class="container">
    <h2 class="section-title">Accedi a CampusLaunch</h2>

    <form action="../actions/login_action.php" method="POST" class="auth-form">
        <input type="email" name="email" placeholder="Email" required class="auth-input">
        <input type="password" name="password" placeholder="Password" required class="auth-input">
        
        <button type="submit" class="btn-full-width">Entra</button>
    </form>

    <div class="auth-footer">
        <p>Non hai ancora un account?</p>
        <a href="register.php" class="link-highlight">Crea un nuovo account</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>