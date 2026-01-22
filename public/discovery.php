<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
require_once '../includes/ImageHelper.php';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Setup Variabili
$searchQuery = $_GET['q'] ?? '';
$filterTag = $_GET['tag'] ?? '';
$filterAvailable = isset($_GET['available']);
$sortOrder = $_GET['sort'] ?? 'newest';

// Usa Helper
$res = ProjectsHelper::getProjects($db, $user_id, $_GET);
$allTags = ProjectsHelper::getAllTags($db);

include '../includes/header.php';
?>

<div class="discovery-container">
    <div class="discovery-header-row">
        <?php include '../includes/searchbar_discovery.php'; ?>

        <?php include '../includes/filter_button.php'; ?>
    </div>

    <?php include '../includes/filter_panel.php'; ?>

    <div class="vertical-list"></div>

    <div class="vertical-list">
        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($p = $res->fetch_assoc()): ?>
                <div class="card-discovery">
                    <div class="cd-image-container">
                        <img 
                            src="<?= htmlspecialchars(ImageHelper::getProjectImageUrl($p['image_url'])) ?>" 
                            alt="<?= htmlspecialchars($p['name']) ?>" 
                            class="cd-image"
                            onerror="this.src='<?= ImageHelper::getFallbackImageUrl($p['id']) ?>'">
                    </div>
                    <div class="cd-body">
                        <h3 class="cd-title"><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="cd-desc"><?= htmlspecialchars($p['intro']) ?></p>
                        <div class="cd-stats-row">
                            <div class="cd-stat">
                                <span class="material-icons-round">group</span>
                                <span><?= $p['occupied_slots'] ?>/<?= $p['total_slots'] ?></span>
                            </div>
                            <a href="../actions/star_project.php?id=<?= $p['id'] ?>"
                                class="cd-stat star-btn <?= $p['is_starred'] ? 'active' : '' ?>">
                                <span class="material-icons-round"><?= $p['is_starred'] ? 'star' : 'star_border' ?></span>
                                <span><?= $p['star_count'] ?></span>
                            </a>
                        </div>
                        <a href="project.php?id=<?= $p['id'] ?>" class="cd-action-btn">
                            <span class="material-icons-round">person_add</span>
                            <span>Unisciti</span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #888;">
                <p>Nessun progetto trovato.</p>
                <a href="discovery.php" style="color: var(--primary-green); font-weight: bold;">Reset filtri</a>
            </div>
        <?php endif; ?>
    </div>
    <div style="height: 80px;"></div>
</div>

<?php include '../includes/footer.php'; ?>