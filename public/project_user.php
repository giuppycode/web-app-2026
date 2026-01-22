<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
require_once '../includes/ImageHelper.php';

// Project id must be provided
$project_id = $_GET['id'] ?? 0;
if (!$project_id) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'] ?? 0;

// Redirect members to the member view
if (ProjectsHelper::isMember($db, $project_id, $user_id)) {
    header("Location: project_member.php?id=" . $project_id);
    exit;
}

$project = ProjectsHelper::getDetails($db, $project_id);
$members = ProjectsHelper::getMembers($db, $project_id);
$roles = ProjectsHelper::getRoles($db, $project_id);

include '../includes/header.php';
?>

<div class="create-project-header mobile-only">
    <a href="index.php" class="back-btn">
        <span class="material-icons-round">arrow_back</span>
    </a>
    <span class="page-title">Project Details</span>
</div>

<div class="create-project-container">

    <!-- PROJECT INFO -->
    <section class="form-section">
        <div class="project-header-display">
            <h1 class="project-title-large"><?= htmlspecialchars($project['name']) ?></h1>
            <p class="project-intro-large"><?= htmlspecialchars($project['intro']) ?></p>
        </div>

        <div class="form-group">
            <label>Description</label>
            <div class="text-display-block">
                <?= nl2br(htmlspecialchars($project['description'])) ?>
            </div>
        </div>

        <div class="form-group">
            <label>Project Image</label>
            <div class="image-display-container">
                <img src="<?= htmlspecialchars(ImageHelper::getProjectImageUrl($project['image_url'])) ?>"
                    alt="Project image" class="current-project-image">
            </div>
        </div>
    </section>

    <!-- LATEST NEWS SECTION -->
    <section class="form-section">
        <h2 class="section-title">Latest news</h2>

        <?php
        $news_result = ProjectsHelper::getLatestNews($db, $project_id);
        if ($news_result->num_rows > 0):
            ?>
            <div class="news-display">
                <?php while ($news = $news_result->fetch_assoc()): ?>
                    <div class="news-item">
                        <span class="news-date"><?= $news['date_fmt'] ?></span>
                        <p class="news-text"><?= htmlspecialchars($news['description']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="empty-state-text">No news posted yet</p>
        <?php endif; ?>
    </section>

    <!-- TEAM SECTION -->
    <section class="form-section">
        <h2 class="section-title">Team</h2>

        <!-- Founders -->
        <div class="team-subsection">
            <h3 class="subsection-title">Founders</h3>
            <div class="team-chips-container">
                <?php
                $members->data_seek(0); // Reset pointer
                while ($member = $members->fetch_assoc()):
                    if ($member['membership_type'] === 'founder'):
                        ?>
                        <div class="team-chip founder-chip">
                            <div class="chip-avatar">
                                <span class="material-icons-round">person</span>
                            </div>
                            <div class="chip-info">
                                <span class="chip-name"><?= htmlspecialchars($member['username']) ?></span>
                                <span class="chip-role">Founder</span>
                            </div>
                        </div>
                        <?php
                    endif;
                endwhile;
                ?>
            </div>
        </div>

        <!-- Members -->
        <div class="team-subsection">
            <h3 class="subsection-title">Members</h3>
            <div class="team-members-container">
                <?php
                $members->data_seek(0); // Reset pointer
                $has_members = false;
                while ($member = $members->fetch_assoc()):
                    if ($member['membership_type'] !== 'founder'):
                        $has_members = true;
                        ?>
                        <div class="member-card">
                            <div class="chip-avatar">
                                <span class="material-icons-round">person</span>
                            </div>
                            <div class="chip-info">
                                <span class="chip-name"><?= htmlspecialchars($member['username']) ?></span>
                                <span class="chip-role">Founder</span>
                            </div>
                        </div>
                        <?php
                    endif;
                endwhile;

                if (!$has_members):
                    ?>
                    <p class="empty-members-text">No members yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Open Positions -->
        <div class="team-subsection">
            <h3 class="subsection-title">Open positions</h3>
            <div id="rolesContainer" class="roles-container">
                <?php while ($role = $roles->fetch_assoc()): ?>
                    <div class="role-chip-large">
                        <div class="role-icon-container">
                            <span class="material-icons-round">work</span>
                        </div>
                        <span class="role-name"><?= htmlspecialchars($role['role_name']) ?></span>
                        <button type="button" class="apply-btn" onclick="openApplicationModal(<?= $role['id'] ?>)">
                            <span>Apply for this position</span>
                        </button>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

</div>


<script>
    function openApplicationModal(roleId) {
        // Placeholder for future application logic
        alert('Application feature coming soon for role ID: ' + roleId);
    }
</script>

<?php include '../includes/footer.php'; ?>