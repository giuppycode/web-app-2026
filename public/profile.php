<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php'; // Fondamentale!
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Usa Helper
$user = UserHelper::getData($db, $_SESSION['user_id']);
$stats = UserHelper::getStats($db, $_SESSION['user_id']);

if (!$user)
    die("Errore utente");
?>

<div class="profile-page-container">
    <div class="profile-card main-stats-card">
        <div class="profile-identity">
            
            <div class="profile-avatar-large" 
                 onclick="openUserProfile(<?= $_SESSION['user_id'] ?>)" 
                 style="cursor: pointer;">
                <span class="material-icons-round">person</span>
            </div>

            <h2 class="profile-username"><?= htmlspecialchars($user['username']) ?></h2>
            <span class="profile-role-badge">founder</span>
        </div>
        <div class="profile-numbers">
            <div class="stat-row"><strong><?= $stats['founded'] ?></strong><span>founded</span></div>
            <div class="stat-divider"></div>
            <div class="stat-row"><strong><?= $stats['starred'] ?></strong><span>starred</span></div>
            <div class="stat-divider"></div>
            <div class="stat-row"><strong><?= $stats['member'] ?></strong><span>member</span></div>
        </div>
    </div>

    <div class="profile-grid-row">
        <div class="profile-card small-card">
            <span class="big-number"><?= $stats['updates'] ?></span>
            <span class="small-label">Posted Updates<br>this week</span>
        </div>
        <div class="profile-card small-card chart-card-container">
            <div class="chart-header">
                <span class="chart-title">Starred</span>
                <span class="chart-subtitle">in the past 7 days</span>
            </div>
            <div class="mini-bar-chart">
                <div class="bar" style="height: 40%;"></div>
                <div class="bar" style="height: 70%;"></div>
                <div class="bar" style="height: 30%;"></div>
                <div class="bar" style="height: 50%;"></div>
                <div class="bar" style="height: 80%;"></div>
                <div class="bar" style="height: 20%;"></div>
                <div class="bar" style="height: 60%;"></div>
            </div>
        </div>
    </div>

    <a href="create_project.php" class="profile-card promo-card">
        <div class="promo-icon"><span class="material-icons-round">local_florist</span></div>
        <div class="promo-text"><strong>Become a founder</strong>
            <p>It's easy to launch your idea and find your team</p>
        </div>
    </a>

    <div class="settings-list">
        <a href="edit_profile.php" class="setting-item">
            <div class="setting-left"><span class="material-icons-round">settings</span><span>Account Settings</span>
            </div>
            <span class="material-icons-round arrow">chevron_right</span>
        </a>
        <a href="../actions/logout.php" class="setting-item">
            <div class="setting-left"><span class="material-icons-round">logout</span><span>Log out</span></div>
            <span class="material-icons-round arrow">chevron_right</span>
        </a>
    </div>
    <div style="height: 80px;"></div>
</div>
<?php include '../includes/footer.php'; ?>