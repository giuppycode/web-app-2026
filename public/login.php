<?php require_once '../includes/db.php';
include '../includes/header.php'; ?>
<h2>Accedi a CampusLaunch</h2>
<form action="../actions/login_action.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Entra</button>
</form>
<?php include '../includes/footer.php'; ?>