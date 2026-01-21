<?php require_once '../includes/db.php';
include '../includes/header.php'; ?>
<div class="container">
    <h2>Unisciti alla Community</h2>
    <form action="../actions/register_action.php" method="POST" class="auth-form">
        <input type="text" name="username" placeholder="Username" required class="auth-input">
        <input type="email" name="email" placeholder="Email universitaria" required class="auth-input">
        <input type="password" name="password" placeholder="Password" required class="auth-input">
        <textarea name="biography" placeholder="Raccontaci brevemente chi sei..." class="auth-input"></textarea>
        <button type="submit" class="btn-full-width">Registrati</button>
    </form>
    <div class="auth-footer">
        <p>Hai già un account?</p>
        <a href="login.php" class="link-highlight">Accedi qui</a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>