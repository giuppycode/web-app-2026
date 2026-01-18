<?php require_once '../includes/db.php';
include '../includes/header.php'; ?>
<h2>Unisciti alla Community</h2>
<form action="../actions/register_action.php" method="POST">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email universitaria" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <textarea name="biography" placeholder="Raccontaci brevemente chi sei..."></textarea><br><br>
    <button type="submit">Registrati</button>
</form>
<p>Hai già un account? <a href="login.php">Accedi qui</a></p>
<?php include '../includes/footer.php'; ?>