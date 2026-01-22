<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$current_user = UserHelper::getData($db, $_SESSION['user_id']);
$error = $_SESSION['create_project_error'] ?? null;
$success = $_SESSION['create_project_success'] ?? null;
unset($_SESSION['create_project_error'], $_SESSION['create_project_success']);

include '../includes/header.php';
?>

<div class="create-project-header mobile-only">
    <a href="index.php" class="back-btn">
        <span class="material-icons-round">arrow_back</span>
    </a>
    <span class="page-title">Create your Project</span>
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

    <form action="../actions/create_project_action.php" method="POST" enctype="multipart/form-data" class="project-form" id="projectForm">
        
        <section class="form-section">
            <h2 class="section-title">Information</h2>

            <div class="form-group">
                <label for="project_title">Title</label>
                <input 
                    type="text" 
                    id="project_title" 
                    name="name" 
                    class="form-input" 
                    placeholder="Project title" 
                    maxlength="100"
                    required>
                <small class="form-hint">Choose a unique and memorable name</small>
            </div>

            <div class="form-group">
                <label for="project_description">Description</label>
                <textarea 
                    id="project_description" 
                    name="description" 
                    class="form-textarea" 
                    rows="6"
                    placeholder="Explain your vision in detail"
                    required></textarea>
                <small class="form-hint">Explain your vision in detail</small>
            </div>

            <div class="form-group">
                <label for="project_summary">Summary</label>
                <textarea 
                    id="project_summary" 
                    name="intro" 
                    class="form-textarea" 
                    rows="3"
                    maxlength="255"
                    placeholder="Brief introduction"
                    required></textarea>
                <small class="form-hint">A brief introduction (max 255 characters)</small>
            </div>

            <div class="form-group">
                <label>Project Image</label>
                <div class="upload-area" id="uploadArea">
                    <input 
                        type="file" 
                        id="project_image" 
                        name="project_image" 
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        class="file-input">
                    <div class="upload-content">
                        <span class="material-icons-round upload-icon">file_upload</span>
                        <span class="upload-text">Add an image</span>
                    </div>
                    <div class="preview-container" id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview">
                        <button type="button" class="remove-image-btn" id="removeImageBtn">
                            <span class="material-icons-round">close</span>
                        </button>
                    </div>
                </div>
                <small class="form-hint">Recommended: 400x200px, max 5MB (JPEG, PNG, WebP)</small>
            </div>
        </section>

        <!-- TEAM SECTION -->
        <section class="form-section">
            <h2 class="section-title">Team</h2>

            <!-- Founders -->
            <div class="team-subsection">
                <h3 class="subsection-title">Founders</h3>
                <div id="foundersContainer" class="team-chips-container">
                    <!-- Current user as founder -->
                    <div class="team-chip founder-chip">
                        <div class="chip-avatar">
                            <span class="material-icons-round">person</span>
                        </div>
                        <div class="chip-info">
                            <span class="chip-name"><?= htmlspecialchars($current_user['firstname'] . ' ' . $current_user['lastname']) ?></span>
                            <span class="chip-role">Founder</span>
                        </div>
                    </div>
                    <!-- Co-founders will be added here dynamically -->
                </div>
                <!-- Hidden input to store co-founder IDs -->
                <input type="hidden" name="co_founders" id="coFoundersInput" value="">
            </div>

            <!-- Members (empty during creation, shown after project exists) -->
            <div class="team-subsection">
                <h3 class="subsection-title">Members</h3>
                <div id="membersContainer" class="team-members-container">
                    <p class="empty-members-text">No members yet. Add co-founders or create roles to expand your team.</p>
                </div>
                
                <button type="button" class="add-members-btn" id="addMembersBtn">
                    <span class="material-icons-round">person_add</span>
                    <span>Add new Members</span>
                    <span class="material-icons-round">arrow_forward</span>
                </button>
            </div>

            <!-- Open Positions -->
            <div class="team-subsection">
                <h3 class="subsection-title">Open positions</h3>
                <div id="rolesContainer" class="roles-container">
                    <!-- Roles will be added here dynamically -->
                </div>
                
                <button type="button" class="add-role-btn" id="addRoleBtn">
                    <span class="material-icons-round">add_circle</span>
                    <span>Add new roles</span>
                    <span class="material-icons-round">arrow_forward</span>
                </button>
                
                <!-- Hidden input to store roles data -->
                <input type="hidden" name="roles" id="rolesInput" value="">
            </div>
        </section>

        <button type="submit" class="btn-launch">
            <span>Launch your project</span>
            <span class="material-icons-round">arrow_forward</span>
        </button>
    </form>
</div>

<script src="../assets/js/create_project.js"></script>

<?php include '../includes/footer.php'; ?>