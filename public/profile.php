<?php
require_once '../includes/db.php';
// Includiamo l'header ma gestiamo la visualizzazione specifica per questa pagina tramite CSS
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. Recupero Dati Utente
$stmt = $db->prepare("SELECT username, email, biography FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// 2. Recupero Statistiche (Queries)
// Count Founded
$founded_res = $db->query("SELECT COUNT(*) as c FROM project_members WHERE user_id = $user_id AND membership_type = 'founder'");
$founded_count = $founded_res->fetch_assoc()['c'];

// Count Starred (Totale)
$starred_res = $db->query("SELECT COUNT(*) as c FROM project_stars WHERE user_id = $user_id");
$starred_count = $starred_res->fetch_assoc()['c'];

// Count Member (Non founder)
$member_res = $db->query("SELECT COUNT(*) as c FROM project_members WHERE user_id = $user_id AND membership_type = 'member'");
$member_count = $member_res->fetch_assoc()['c'];

// Count Updates (News pubblicate negli ultimi 7 giorni)
$updates_res = $db->query("SELECT COUNT(*) as c FROM project_news WHERE author_id = $user_id AND created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
$updates_count = $updates_res->fetch_assoc()['c'];

// NOTA: Il grafico "Starred in the past 7 days" richiede dati temporali che la tabella `project_stars` attuale non ha.
// Simuleremo il grafico visivamente con CSS per rispettare il mockup.
?>

<div class="profile-page-container">

    <div class="profile-card main-stats-card">
        <div class="profile-identity">
            <div class="profile-avatar-large">
                <span class="material-icons-round">person</span>
            </div>
            <h2 class="profile-username"><?= htmlspecialchars($user['username']) ?></h2>
            <span class="profile-role-badge">founder</span>
        </div>

        <div class="profile-numbers">
            <div class="stat-row">
                <strong><?= $founded_count ?></strong>
                <span>founded</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-row">
                <strong><?= $starred_count ?></strong>
                <span>starred</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat-row">
                <strong><?= $member_count ?></strong>
                <span>member</span>
            </div>
        </div>
    </div>

    <div class="profile-grid-row">
        <div class="profile-card small-card">
            <span class="big-number"><?= $updates_count ?></span>
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
        <div class="promo-icon">
            <span class="material-icons-round">local_florist</span>
        </div>
        <div class="promo-text">
            <strong>Become a founder</strong>
            <p>It's easy to launch your idea and find your team</p>
        </div>
    </a>

    <div class="settings-list">
        <a href="edit_profile.php" class="setting-item">
            <div class="setting-left">
                <span class="material-icons-round">settings</span>
                <span>Account Settings</span>
            </div>
            <span class="material-icons-round arrow">chevron_right</span>
        </a>

        <a href="#" class="setting-item">
            <div class="setting-left">
                <span class="material-icons-round">help_outline</span>
                <span>Help</span>
            </div>
            <span class="material-icons-round arrow">chevron_right</span>
        </a>

        <hr class="setting-divider">

        <a href="../actions/logout.php" class="setting-item">
            <div class="setting-left">
                <span class="material-icons-round">logout</span>
                <span>Log out</span>
            </div>
            <span class="material-icons-round arrow">chevron_right</span>
        </a>
    </div>

    <div style="height: 80px;"></div>
</div>

<?php include '../includes/footer.php'; ?>