<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// 1. Recupero parametri Home (Search + Filters)
// Passiamo tutto $_GET all'helper che cercherà le chiavi 'q_fav', 'tag_fav', ecc.
$favorites = ProjectsHelper::getFavorites($db, $user_id, $_GET);

// 2. Recupero altri dati
$participating = ProjectsHelper::getParticipating($db, $user_id);
$allTags = ProjectsHelper::getAllTags($db); // Serve per il filter_panel_home

// Variabili per la UI (per mostrare pallino rosso se filtrato)
$favTag = $_GET['tag_fav'] ?? '';
$favAvailable = isset($_GET['available_fav']);
?>

<style>
    @media (min-width: 769px) {
        body {
            background: #f4f7f6;
        }
    }
</style>

<div class="home-header mobile-only">
    <span class="page-title">Home page</span>
    <div class="notification-bell"><span class="material-icons-round">notifications</span></div>
</div>

<div class="home-container">

    <h2 class="section-title">Participating</h2>
    <?php if ($participating->num_rows > 0): ?>
        <div class="horizontal-scroll">
            <?php while ($p = $participating->fetch_assoc()): ?>
                <a href="project_member.php?id=<?= $p['id'] ?>" class="card-participating">
                    <div class="cp-header">
                        <div class="user-avatar"><span class="material-icons-round">person</span></div>
                        <div class="user-role"><?= ucfirst($p['membership_type']) ?></div>
                        <span class="material-icons-round arrow-icon">chevron_right</span>
                    </div>
                    <h3 class="cp-title"><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="cp-desc"><?= substr(htmlspecialchars($p['intro']), 0, 60) ?>...</p>
                    <div class="cp-footer">
                        <span class="cp-stat"><span class="material-icons-round">group</span> <?= $p['member_count'] ?></span>
                        <span class="cp-stat"><span class="material-icons-round">star</span> <?= $p['star_count'] ?></span>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="empty-state">Non partecipi ancora a nessun progetto.</p>
    <?php endif; ?>

    <div class="section-header-row"
        style="display: flex; justify-content: space-between; align-items: center; margin-top: 30px; margin-bottom: 15px;">

        <h2 class="section-title" style="margin: 0;">Yours favorite</h2>

        <div style="display: flex; align-items: center; gap: 10px;">

            <?php include '../includes/searchbar_home.php'; ?>

            <button class="filter-btn" type="button" onclick="toggleFiltersHome()">
                <span class="material-icons-round">tune</span>
                <?php if ($favTag || $favAvailable): ?>
                    <span class="filter-badge"></span>
                <?php endif; ?>
            </button>
        </div>
    </div>

    <?php include '../includes/filter_panel_home.php'; ?>

    <?php if (!empty($_GET['q_fav']) || $favTag || $favAvailable): ?>
        <p style="margin-bottom: 15px; color: #666; font-size: 0.9rem;">
            Filtri attivi sui preferiti. <a href="index.php"
                style="color: var(--primary-green); font-weight: 600;">Reset</a>
        </p>
    <?php endif; ?>

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
                        <?php $news_res = ProjectsHelper::getLatestNews($db, $fav['id']); ?>
                        <?php if ($news_res->num_rows > 0): ?>
                            <ul class="news-list">
                                <?php while ($news = $news_res->fetch_assoc()): ?>
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
            <p class="empty-state" style="text-align:center; padding: 20px;">
                Nessun progetto preferito trovato con questi filtri.
            </p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>