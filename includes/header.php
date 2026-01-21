<?php if (session_status() === PHP_SESSION_NONE)
    session_start(); ?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>CampusLaunch</title>
    <link rel="stylesheet" href="../assets/css/output.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="bg-light-green-bg text-text-dark font-sans pb-[90px]">

    <nav
        class="group h-[70px] w-full bg-white shadow-md fixed top-0 left-0 z-50 flex items-center justify-between px-5 transition-all duration-300">
        <div class="text-2xl font-bold bg-gradient-to-r from-primary-green to-green-400 bg-clip-text text-transparent">
            🚀 CampusLaunch</div>

        <div class="hidden md:flex items-center gap-5">
            <a href="index.php"
                class="text-text-dark font-medium hover:text-primary-green transition-colors no-underline">Discovery</a>
            <a href="activity.php"
                class="text-text-dark font-medium hover:text-primary-green transition-colors no-underline">News</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="create_project.php"
                    class="px-5 py-2 bg-gradient-to-r from-primary-green to-green-400 text-white rounded-full font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all no-underline">Crea
                    (+ )</a>
                <a href="profile.php"
                    class="text-text-dark font-medium hover:text-primary-green transition-colors no-underline">Profilo</a>
                <a href="../actions/logout.php"
                    class="text-text-dark font-medium hover:text-primary-green transition-colors no-underline">Logout</a>
            <?php else: ?>
                <a href="login.php"
                    class="text-text-dark font-medium hover:text-primary-green transition-colors no-underline">Login</a>
                <a href="register.php"
                    class="px-5 py-2 bg-gradient-to-r from-primary-green to-green-400 text-white rounded-full font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all no-underline">Registrati</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="container">