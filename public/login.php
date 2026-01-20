<?php 
require_once '../includes/db.php';
include '../includes/header.php'; 
?>

<div class="container">
    <h2 class="section-title">Accedi a CampusLaunch</h2>

    <?php if (isset($_GET['error'])): ?>
        <div style="background-color: #fee2e2; color: #b91c1c; padding: 12px; border-radius: 12px; margin-bottom: 20px; text-align: center; border: 1px solid #fca5a5; font-weight: 600;">
            ⚠️ Email o Password non corretti.
        </div>
    <?php endif; ?>

    <form action="../actions/login_action.php" method="POST" class="auth-form">
        
        <input type="email" name="email" placeholder="Email" required class="auth-input"
               value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">

        <input type="password" name="password" placeholder="Password" required class="auth-input">
        
        <button type="submit" class="btn-full-width">Entra</button>
    </form>

    <div class="auth-footer">
        <p>Non hai ancora un account?</p>
        <a href="register.php" class="link-highlight">Crea un nuovo account</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>