<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>CampusLaunch</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        nav {
            background: #333;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        nav a {
            color: white;
            margin-right: 15px;
            text-decoration: none;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
            font-family: sans-serif;
        }

        .project-card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .tag {
            background: #e0e0e0;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.8em;
        }
    </style>
</head>

<body>
    <nav>
        <div>
            <strong>🚀 CampusLaunch</strong>
            <a href="index.php">Discovery</a>
            <a href="activity.php">News</a>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="profile.php">Mio Profilo</a>
                <a href="../actions/logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Registrati</a>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container"></div>