<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Recupero Dati
$user = UserHelper::getData($db, $user_id);

// 1. Progetti Fondati
$foundedProjects = ProjectsHelper::getFoundedProjects($db, $user_id);

// 2. Progetti Partecipati (Solo membro)
$memberProjects = ProjectsHelper::getMemberProjects($db, $user_id);

// 3. Notifiche (dai progetti fondati)
$notifications = ProjectsHelper::getFounderNotifications($db, $user_id);
?>


<div class="container">

    <h1 class="founder-title">
        Welcome Founder !
    </h1>

    <a href="create_project.php" class="create-card">
        <span class="create-text">Create a new<br>project idea!</span>
        <div class="plus-btn-circle">
            <span class="material-icons-round" style="font-size: 32px;">add</span>
        </div>
    </a>

    <h2 class="section-label">Notifications</h2>
    <div class="notifications-card">
        <?php if ($notifications->num_rows > 0): ?>
            <?php while ($notif = $notifications->fetch_assoc()): ?>
                <div class="notif-item">
                    <span class="notif-project"><?= htmlspecialchars($notif['project_name']) ?></span>
                    <p class="notif-desc"><?= htmlspecialchars($notif['description']) ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="notif-desc" style="font-style: italic; color: #999;">Nessuna nuova notifica.</p>
        <?php endif; ?>
    </div>

    <h2 class="section-label">Your Founded Projects</h2>

    <?php if ($foundedProjects->num_rows > 0): ?>
        <div class="project-pill-list">
            <?php while ($p = $foundedProjects->fetch_assoc()): ?>
                <a href="project_admin.php?id=<?= $p['id'] ?>" class="project-pill">
                    <span class="pill-title"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="pill-action">manage</span>
                </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="color: #666; margin-bottom: 20px;">Non hai ancora fondato progetti.</p>
    <?php endif; ?>

    <h2 class="section-label" style="margin-top: 30px;">Your Participating Projects</h2>

    <?php if ($memberProjects->num_rows > 0): ?>
        <div class="project-pill-list">
            <?php while ($p = $memberProjects->fetch_assoc()): ?>
                <a href="project.php?id=<?= $p['id'] ?>" class="project-pill">
                    <span class="pill-title"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="pill-action">manage</span> </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="color: #666;">Non partecipi ancora a nessun progetto.</p>
    <?php endif; ?>

    <div style="height: 100px;"></div>
</div>

<style>
    .bottom-nav {
        display: none !important;
    }

    .bottom-nav-founder {
        display: flex !important;
    }
</style>

<div class="bottom-nav bottom-nav-founder" style="
    position: fixed; bottom: 20px; left: 50%; transform: translateX(-50%);
    width: 90%; max-width: 400px;
    background: #ffffff; border-radius: 30px;
    display: flex; justify-content: space-between; align-items: center;
    padding: 10px 20px; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    z-index: 1000;">

    <a href="index.php" class="nav-item"><span class="material-icons-round">home</span></a>
    <a href="discovery.php" class="nav-item"><span class="material-icons-round">search</span></a>
    <a href="activity.php" class="nav-item"><span class="material-icons-round">grid_view</span></a>
    <a href="founder.php" class="nav-item active">
        <span class="material-icons-round">local_florist</span>
        <span class="label">Founder</span>
    </a>
    <a href="profile.php" class="nav-item"><span class="material-icons-round">person</span></a>
</div>

<?php echo '<script src="../assets/js/main.js"></script></body></html>'; ?>