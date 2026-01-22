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
                    <div class="notif-content-wrapper">
                        <span class="notif-project"><?= htmlspecialchars($notif['project_name']) ?></span>
                        <p class="notif-desc"><?= htmlspecialchars($notif['description']) ?></p>
                    </div>

                    <?php if ($notif['type'] === 'application' && $notif['application_id']): ?>
                        <div class="notif-actions">
                            <button type="button" class="btn-action check"
                                onclick="handleApplication(<?= $notif['application_id'] ?>, 'accept', this)">
                                <span class="material-icons-round">check</span>
                            </button>
                            <button type="button" class="btn-action close"
                                onclick="handleApplication(<?= $notif['application_id'] ?>, 'decline', this)">
                                <span class="material-icons-round">close</span>
                            </button>
                        </div>
                    <?php endif; ?>
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
                <a href="project_member.php?id=<?= $p['id'] ?>" class="project-pill">
                    <span class="pill-title"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="pill-action">manage</span> </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p style="color: #666;">Non partecipi ancora a nessun progetto.</p>
    <?php endif; ?>

    <div style="height: 100px;"></div>
</div>


<script>
    async function handleApplication(appId, action, btnElement) {
        if (!confirm('Are you sure you want to ' + action + ' this application?')) return;

        try {
            const response = await fetch('../actions/handle_application.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    application_id: appId,
                    action: action
                })
            });

            const data = await response.json();

            if (data.success) {
                // Find the parent .notif-item and remove it or update it
                const item = btnElement.closest('.notif-item');
                if (item) {
                    item.style.opacity = '0.5';
                    item.innerHTML = '<p class="notif-desc">Application ' + action + 'ed</p>';
                    setTimeout(() => item.remove(), 2000);
                }
            } else {
                alert('Error: ' + data.message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An error occurred.');
        }
    }
</script>

<?php include '../includes/footer.php'; ?>