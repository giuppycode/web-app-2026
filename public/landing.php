<?php
require_once '../includes/db.php';

// Se l'utente è già loggato, lo reindirizziamo alla home o dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CampusLaunch</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/landing.css">
</head>

<?php include '../includes/header.php'; ?>

<body>
    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Benvenuto in CampusLaunch</h1>
            <p class="hero-subtitle">
                Il luogo dove le idee prendono vita. Connettiti con altri studenti, collabora su progetti innovativi e
                lancia la tua visione nel mondo.
            </p>

            <div class="cta-group">
                <a href="login.php" class="btn-landing btn-primary-landing">
                    Accedi ora
                </a>
                <a href="register.php" class="btn-landing btn-secondary-landing">
                    Crea account
                </a>
            </div>
        </div>
    </div>

    <div class="features">
        <div class="feature-card">
            <span class="material-icons-round feature-icon">rocket_launch</span>
            <h3 class="feature-title">Lancia Progetti</h3>
            <p class="feature-desc">Hai un'idea? Trova il team giusto e trasforma la tua visione in realtà.</p>
        </div>
        <div class="feature-card">
            <span class="material-icons-round feature-icon">groups</span>
            <h3 class="feature-title">Collabora</h3>
            <p class="feature-desc">Unisciti a team multidisciplinari e impara lavorando fianco a fianco.</p>
        </div>
        <div class="feature-card">
            <span class="material-icons-round feature-icon">public</span>
            <h3 class="feature-title">Network</h3>
            <p class="feature-desc">Espandi la tua rete professionale e connettiti con talenti da tutto il campus.</p>
        </div>
    </div>
</body>

</html>