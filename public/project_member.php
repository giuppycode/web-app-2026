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

if (!ProjectsHelper::isMember($db, $project_id, $user_id)) {
    header("Location: project_member.php?id=" . $project_id);
    exit;
}

$project = ProjectsHelper::getDetails($db, $project_id);
$members = ProjectsHelper::getMembers($db, $project_id);
$roles = ProjectsHelper::getRoles($db, $project_id);
$is_founder = ProjectsHelper::isFounder($db, $project_id, $user_id);

$error = $_SESSION['project_member_error'] ?? null;
$success = $_SESSION['project_member_success'] ?? null;
unset($_SESSION['project_member_error'], $_SESSION['project_member_success']);

include '../includes/header.php';
?>

<div class="create-project-header mobile-only">
    <a href="index.php" class="back-btn">
        <span class="material-icons-round">arrow_back</span>
    </a>
    <span class="page-title">Edit your Project</span>
    <button class="menu-btn"><span class="material-icons-round">more_vert</span></button>
</div>

<div class="create-project-container">

    <?php if ($error): ?>
        <div class="alert alert-error">
            <span class="material-icons-round">error</span>
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success">
            <span class="material-icons-round">check_circle</span>
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <form action="../actions/update_project_action.php" method="POST" enctype="multipart/form-data" class="project-form"
        id="projectForm">
        <input type="hidden" name="project_id" value="<?= $project_id ?>">

        <section class="form-section">
            <h2 class="section-title">Information</h2>

            <div class="form-group">
                <label>Title</label>
                <?php if ($is_founder): ?>
                    <div class="dropdown-input" onclick="toggleEdit('titleEdit')">
                        <span id="titleDisplay" class="dropdown-display"><?= htmlspecialchars($project['name']) ?></span>
                        <span class="material-icons-round">expand_more</span>
                    </div>
                    <div id="titleEdit" class="edit-container" style="display: none;">
                        <input type="text" name="name" class="form-input" value="<?= htmlspecialchars($project['name']) ?>"
                            maxlength="100" required>
                    </div>
                <?php else: ?>
                    <div class="dropdown-input disabled">
                        <span class="dropdown-display"><?= htmlspecialchars($project['name']) ?></span>
                        <span class="material-icons-round" style="color: var(--text-secondary);">lock</span>
                    </div>
                    <small class="form-hint" style="color: var(--text-secondary);">Only founder can modify this
                        section</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Description</label>
                <?php if ($is_founder): ?>
                    <div class="dropdown-input" onclick="toggleEdit('descEdit')">
                        <span id="descDisplay"
                            class="dropdown-display"><?= substr(htmlspecialchars($project['description']), 0, 80) ?>...</span>
                        <span class="material-icons-round">expand_more</span>
                    </div>
                    <div id="descEdit" class="edit-container" style="display: none;">
                        <textarea name="description" class="form-textarea" rows="6"
                            required><?= htmlspecialchars($project['description']) ?></textarea>
                    </div>
                <?php else: ?>
                    <div class="dropdown-input disabled">
                        <span
                            class="dropdown-display"><?= substr(htmlspecialchars($project['description']), 0, 80) ?>...</span>
                        <span class="material-icons-round" style="color: var(--text-secondary);">lock</span>
                    </div>
                    <small class="form-hint" style="color: var(--text-secondary);">Only founder can modify this
                        section</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Summary</label>
                <?php if ($is_founder): ?>
                    <div class="dropdown-input" onclick="toggleEdit('summaryEdit')">
                        <span id="summaryDisplay" class="dropdown-display"><?= htmlspecialchars($project['intro']) ?></span>
                        <span class="material-icons-round">expand_more</span>
                    </div>
                    <div id="summaryEdit" class="edit-container" style="display: none;">
                        <textarea name="intro" class="form-textarea" rows="3" maxlength="255"
                            required><?= htmlspecialchars($project['intro']) ?></textarea>
                    </div>
                <?php else: ?>
                    <div class="dropdown-input disabled">
                        <span class="dropdown-display"><?= htmlspecialchars($project['intro']) ?></span>
                        <span class="material-icons-round" style="color: var(--text-secondary);">lock</span>
                    </div>
                    <small class="form-hint" style="color: var(--text-secondary);">Only founder can modify this
                        section</small>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Project Image</label>
                <div class="upload-area" id="uploadArea">
                    <input type="file" id="project_image" name="project_image"
                        accept="image/jpeg,image/png,image/jpg,image/webp" class="file-input" <?= !$is_founder ? 'disabled' : '' ?>>

                    <div class="current-image-container" id="currentImageContainer">
                        <img src="<?= htmlspecialchars(ImageHelper::getProjectImageUrl($project['image_url'])) ?>"
                            alt="Current project image" id="currentImage" class="current-project-image">
                        <?php if ($is_founder): ?>
                            <div class="image-overlay">
                                <span class="material-icons-round">edit</span>
                                <span>Change image</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="preview-container" id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview">
                        <button type="button" class="remove-image-btn" id="removeImageBtn">
                            <span class="material-icons-round">close</span>
                        </button>
                    </div>
                </div>
                <?php if ($is_founder): ?>
                    <small class="form-hint">Click to replace image (max 5MB)</small>
                <?php else: ?>
                    <small class="form-hint" style="color: var(--text-secondary);">Only founder can modify this
                        section</small>
                <?php endif; ?>
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

            <button type="button" class="post-update-btn" onclick="openNewsModal()">
                <span>Post an update</span>
                <span class="update-subtitle">News for the followers</span>
                <span class="material-icons-round">arrow_forward</span>
            </button>
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
                                    <span class="chip-role"><?= htmlspecialchars($member['role_name'] ?? 'Member') ?></span>
                                </div>
                                <?php if ($is_founder): ?>
                                    <button type="button" class="member-menu-btn"
                                        onclick="openMemberMenu(<?= $member['user_id'] ?>, '<?= htmlspecialchars($member['username']) ?>')">
                                        <span class="material-icons-round">more_vert</span>
                                    </button>
                                <?php endif; ?>
                            </div>
                            <?php
                        endif;
                    endwhile;

                    if (!$has_members):
                        ?>
                        <p class="empty-members-text">No members yet. Users can join through open positions.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Open Positions -->
            <div class="team-subsection">
                <h3 class="subsection-title">Open positions</h3>
                <div id="rolesContainer" class="roles-container">
                    <?php while ($role = $roles->fetch_assoc()): ?>
                        <div class="role-chip-large" data-role-id="<?= $role['id'] ?>">
                            <div class="role-icon-container">
                                <span class="material-icons-round">work</span>
                            </div>
                            <span class="role-name"><?= htmlspecialchars($role['role_name']) ?></span>
                            <?php if ($is_founder): ?>
                                <button type="button" class="role-menu-btn"
                                    onclick="openRoleMenu(<?= $role['id'] ?>, '<?= htmlspecialchars($role['role_name']) ?>')">
                                    <span class="material-icons-round">more_vert</span>
                                </button>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <?php if ($is_founder): ?>
                    <button type="button" class="add-role-btn" onclick="openAddRoleModal()">
                        <span class="material-icons-round">add_circle</span>
                        <span>Add new roles</span>
                        <span class="material-icons-round">arrow_forward</span>
                    </button>
                    <small class="form-hint">Expand the project reach</small>
                <?php else: ?>
                    <small class="form-hint" style="color: var(--text-secondary); margin-top: 10px;">Only founder can modify
                        this section</small>
                <?php endif; ?>
            </div>

            <?php if ($is_founder): ?>
                <button type="button" class="add-members-btn" onclick="openApplicationsModal()">
                    <span class="material-icons-round">person_add</span>
                    <span>Add new Members</span>
                    <span class="material-icons-round">arrow_forward</span>
                </button>
                <small class="form-hint">Expand the project reach</small>
            <?php endif; ?>
        </section>

        <?php if ($is_founder): ?>
            <button type="submit" class="btn-launch">
                <span>Update project</span>
                <span class="material-icons-round">arrow_forward</span>
            </button>
        <?php endif; ?>
    </form>
</div>

<!-- Post News Modal -->
<div id="newsModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Post an Update</h3>
            <button type="button" class="modal-close" onclick="closeNewsModal()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="../actions/post_news.php" method="POST" id="newsForm">
                <input type="hidden" name="project_id" value="<?= $project_id ?>">
                <div class="form-group">
                    <label for="news_text">Update message</label>
                    <textarea id="news_text" name="news_text" class="form-textarea" rows="4"
                        placeholder="Share what's new with your followers..." required></textarea>
                </div>
                <button type="submit" class="btn-primary">
                    <span class="material-icons-round">send</span>
                    <span>Post Update</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Add Role Modal -->
<div id="addRoleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Role</h3>
            <button type="button" class="modal-close" onclick="closeAddRoleModal()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="../actions/add_role.php" method="POST">
                <input type="hidden" name="project_id" value="<?= $project_id ?>">
                <div class="form-group">
                    <label for="role_name">Role Name</label>
                    <input type="text" id="role_name" name="role_name" class="form-input"
                        placeholder="e.g., Frontend Developer, Designer..." maxlength="100" required>
                </div>
                <button type="submit" class="btn-primary">
                    <span class="material-icons-round">add</span>
                    <span>Add Role</span>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Member Actions Modal -->
<div id="memberModal" class="modal" style="display: none;">
    <div class="modal-content modal-small">
        <div class="modal-header">
            <h3 id="memberModalTitle">Member Actions</h3>
            <button type="button" class="modal-close" onclick="closeMemberModal()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="action-list">
                <button type="button" class="action-item" onclick="editMemberRole()">
                    <span class="material-icons-round">edit</span>
                    <span>Change Role</span>
                </button>
                <button type="button" class="action-item danger" onclick="removeMember()">
                    <span class="material-icons-round">person_remove</span>
                    <span>Remove Member</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Role Actions Modal -->
<div id="roleModal" class="modal" style="display: none;">
    <div class="modal-content modal-small">
        <div class="modal-header">
            <h3 id="roleModalTitle">Role Actions</h3>
            <button type="button" class="modal-close" onclick="closeRoleModal()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="action-list">
                <button type="button" class="action-item danger" onclick="deleteRole()">
                    <span class="material-icons-round">delete</span>
                    <span>Delete Role</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Applications Modal (Placeholder for now) -->
<div id="applicationsModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Role Applications</h3>
            <button type="button" class="modal-close" onclick="closeApplicationsModal()">
                <span class="material-icons-round">close</span>
            </button>
        </div>
        <div class="modal-body">
            <p class="empty-state-text">No applications yet. This feature will show users who applied for roles.</p>
        </div>
    </div>
</div>

<script src="../assets/js/project_admin.js"></script>

<?php include '../includes/footer.php'; ?>