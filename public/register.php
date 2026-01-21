<?php require_once '../includes/db.php';
include '../includes/header.php'; ?>

<div class="container">

    <?php if (isset($_GET['error'])): ?>
        <div class="error-alert">
            ⚠️ <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <h2 class="section-title">Unisciti alla Community</h2>
    
    <form action="../actions/register_action.php" method="POST" class="auth-form">
        <div class="row-2">
            <input type="text" name="firstname" placeholder="First Name" required class="auth-input">
            <input type="text" name="lastname" placeholder="Last Name" required class="auth-input">
        </div>

        <input type="email" name="email" placeholder="Email universitaria" required class="auth-input">
        <input type="password" name="password" placeholder="Password" required class="auth-input">
       
        <input type="text" name="username" placeholder="Username" required class="auth-input">
        <input type="text" name="number" placeholder="Phone Number" required class="auth-input">
        <input type="text" name="faculty" placeholder="Faculty" required class="auth-input">
        
        
        
        <textarea name="biography" placeholder="Raccontaci brevemente chi sei..." class="auth-input" rows="3"></textarea>
        
        <button type="submit" class="btn-full-width">Registrati</button>
    </form>

    <div class="auth-footer">
        <p>Hai già un account?</p>
        <a href="login.php" class="link-highlight">Accedi qui</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>