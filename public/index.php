<?php
require_once '../includes/db.php';
// Nota: Non includiamo header.php standard perché l'header di questa pagina è custom (trasparente/integrato)
// Gestiamo la sessione manualmente qui se serve, oppure includiamo un "header_minimal.php"
if (session_status() === PHP_SESSION_NONE)
    session_start();
if (!isset($_SESSION['user_id']))
    header("Location: login.php");

$user_id = $_SESSION['user_id'];

// 1. QUERY PARTICIPATING (Progetti di cui sono membro/founder)
$sql_part = "SELECT p.*, pm.membership_type, 
            (SELECT COUNT(*) FROM project_members WHERE project_id = p.id) as member_count,
            (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
            FROM projects p 
            JOIN project_members pm ON p.id = pm.project_id 
            WHERE pm.user_id = ?";
$stmt = $db->prepare($sql_part);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$participating = $stmt->get_result();

// 2. QUERY FAVORITE (Progetti stellati)
// Recuperiamo i progetti stellati
$sql_fav = "SELECT p.*, 
            (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
            FROM projects p 
            JOIN project_stars ps ON p.id = ps.project_id 
            WHERE ps.user_id = ?";
$stmt2 = $db->prepare($sql_fav);
$stmt2->bind_param("i", $user_id);
$stmt2->execute();
$favorites = $stmt2->get_result();
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Home - CampusLaunch</title>
    <link rel="stylesheet" href="../assets/css/mobile.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
</head>

<body class="home-body">

    <div class="home-header">
        <span class="page-title">Home page</span>
        <div class="notification-bell">
            <span class="material-icons-round">notifications</span>
        </div>
    </div>

    <div class="container home-container">

        <h2 class="section-title">Participating</h2>

        <?php if ($participating->num_rows > 0): ?>
            <div class="horizontal-scroll">
                <?php while ($p = $participating->fetch_assoc()): ?>
                    <a href="project.php?id=<?= $p['id'] ?>" class="card-participating">
                        <div class="cp-header">
                            <div class="user-avatar">
                                <span class="material-icons-round">person</span>
                            </div>
                            <div class="user-role"><?= ucfirst($p['membership_type']) ?></div>
                            <span class="material-icons-round arrow-icon">chevron_right</span>
                        </div>

                        <h3 class="cp-title"><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="cp-desc"><?= substr(htmlspecialchars($p['intro']), 0, 60) ?>...</p>

                        <div class="cp-footer">
                            <span class="cp-stat"><span class="material-icons-round">group</span>
                                <?= $p['member_count'] ?></span>
                            <span class="cp-stat"><span class="material-icons-round">person_add</span>
                                <?= $p['total_slots'] - $p['occupied_slots'] ?></span>
                            <span class="cp-stat"><span class="material-icons-round">star</span> <?= $p['star_count'] ?></span>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="empty-state">Non partecipi ancora a nessun progetto.</p>
        <?php endif; ?>

        <div class="section-header-row">
            <h2 class="section-title">Yours favorite</h2>
            <div class="action-icons">
                <button class="icon-btn"><span class="material-icons-round">search</span></button>
                <button class="icon-btn"><span class="material-icons-round">filter_list</span></button>
            </div>
        </div>

        <div class="favorites-list">
            <?php if ($favorites->num_rows > 0): ?>
                <?php while ($fav = $favorites->fetch_assoc()): ?>
                    <div class="card-favorite">
                        <div class="cf-header">
                            <h3 class="cf-title"><?= htmlspecialchars($fav['name']) ?></h3>
                            <div class="cf-stars">
                                <span class="material-icons-round star-icon">star_border</span> <?= $fav['star_count'] ?>
                            </div>
                        </div>

                        <div class="cf-news-section">
                            <h4>Latest news</h4>
                            <?php
                            // Query interna per le ultime 3 news di questo progetto
                            // (Nota: in produzione si farebbe con una JOIN ottimizzata o Eager Loading)
                            $pid = $fav['id'];
                            $news_sql = $db->query("SELECT description, DATE_FORMAT(created_at, '%b %d') as date_fmt FROM project_news WHERE project_id = $pid ORDER BY created_at DESC LIMIT 3");
                            ?>

                            <?php if ($news_sql->num_rows > 0): ?>
                                <ul class="news-list">
                                    <?php while ($news = $news_sql->fetch_assoc()): ?>
                                        <li>
                                            <p><?= htmlspecialchars($news['description']) ?></p>
                                            <span class="news-date"><?= $news['date_fmt'] ?></span>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php else: ?>
                                <p class="no-news">Nessuna news recente.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="empty-state">Non hai ancora progetti preferiti.</p>
            <?php endif; ?>
        </div>

    </div> <?php include '../includes/footer.php'; ?>