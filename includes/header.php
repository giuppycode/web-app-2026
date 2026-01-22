<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CampusLaunch</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/components.css">

    <link rel="stylesheet" href="../assets/css/home.css">
    <link rel="stylesheet" href="../assets/css/discovery.css">
    <link rel="stylesheet" href="../assets/css/create_project.css">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <link rel="stylesheet" href="../assets/css/founder.css">
    <link rel="stylesheet" href="../assets/css/desktop.css" media="(min-width: 769px)">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body>

    <nav class="top-nav">
        <span class="top-menu-toggle material-icons-round" onclick="toggleDrawer()">menu</span>
        <div class="brand">🚀 CampusLaunch</div>

        <div class="desktop-links">
            <a href="index.php">Discovery</a>
            <a href="activity.php">News</a>
            <a href="search.php">Cerca</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="create_project.php" class="btn-primary">Crea (+ )</a>
                <a href="profile.php">Profilo</a>
                <a href="../actions/logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php" class="btn-primary">Registrati</a>
            <?php endif; ?>
        </div>

        <a href="search.php" class="material-icons-round"
            style="color: var(--text-dark); text-decoration: none;">search</a>
    </nav>

    <div class="mobile-drawer" id="mobileDrawer">
        <div class="drawer-header">
            <span class="brand">Menu</span>
            <span class="drawer-close material-icons-round" onclick="toggleDrawer()">close</span>
        </div>
        <a href="index.php"><span class="material-icons-round"
                style="vertical-align: middle; margin-right: 10px;">explore</span> Discovery</a>
        <a href="activity.php"><span class="material-icons-round"
                style="vertical-align: middle; margin-right: 10px;">rss_feed</span> News</a>
        <a href="search.php"><span class="material-icons-round"
                style="vertical-align: middle; margin-right: 10px;">search</span> Cerca</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="create_project.php"><span class="material-icons-round"
                    style="vertical-align: middle; margin-right: 10px;">add_circle</span> Crea Progetto</a>
            <a href="profile.php"><span class="material-icons-round"
                    style="vertical-align: middle; margin-right: 10px;">person</span> Mio Profilo</a>
            <hr>
            <a href="../actions/logout.php" style="color: var(--secondary-orange);"><span class="material-icons-round"
                    style="vertical-align: middle; margin-right: 10px;">logout</span> Logout</a>
        <?php else: ?>
            <hr>
            <a href="login.php">Login</a>
            <a href="register.php" style="color: var(--primary-green); font-weight: bold;">Registrati</a>
        <?php endif; ?>
    </div>

    <div class="container">

        <script>
            function toggleDrawer() {
                document.getElementById('mobileDrawer').classList.toggle('active');
            }
        </script>