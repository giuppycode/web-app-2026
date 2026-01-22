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

if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    header("Location: project.php?id=" . $project_id);
    exit;
}

$project = ProjectsHelper::getDetails($db, $project_id);
$members = ProjectsHelper::getMembers($db, $project_id);
$roles = ProjectsHelper::getRoles($db, $project_id);

$error = $_SESSION['project_admin_error'] ?? null;
$success = $_SESSION['project_admin_success'] ?? null;
unset($_SESSION['project_admin_error'], $_SESSION['project_admin_success']);

include '../includes/header.php';
?>

<div class="create-project-header mobile-only">
    <a href="project.php?id=<?= $project_id ?>" class="back-btn">
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

    <form action="../actions/update_project_action.php" method="POST" enctype="multipart/form-data" class="project-form" id="projectForm">
        <input type="hidden" name="project_id" value="<?= $project_id ?>">
        
        <section class="form-section">
            <h2 class="section-title">Information</h2>

            <div class="form-group">
                <label>Title</label>
                <div class="dropdown-input" onclick="toggleEdit('titleEdit')">
                    <span id="titleDisplay" class="dropdown-display"><?= htmlspecialchars($project['name']) ?></span>
                    <span class="material-icons-round">expand_more</span>
                </div>
                <div id="titleEdit" class="edit-container" style="display: none;">
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        value="<?= htmlspecialchars($project['name']) ?>"
                        maxlength="100"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <div class="dropdown-input" onclick="toggleEdit('descEdit')">
                    <span id="descDisplay" class="dropdown-display"><?= substr(htmlspecialchars($project['description']), 0, 80) ?>...</span>
                    <span class="material-icons-round">expand_more</span>
                </div>
                <div id="descEdit" class="edit-container" style="display: none;">
                    <textarea 
                        name="description" 
                        class="form-textarea" 
                        rows="6"
                        required><?= htmlspecialchars($project['description']) ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label>Summary</label>
                <div class="dropdown-input" onclick="toggleEdit('summaryEdit')">
                    <span id="summaryDisplay" class="dropdown-display"><?= htmlspecialchars($project['intro']) ?></span>
                    <span class="material-icons-round">expand_more</span>
                </div>
                <div id="summaryEdit" class="edit-container" style="display: none;">
                    <textarea 
                        name="intro" 
                        class="form-textarea" 
                        rows="3"
                        maxlength="255"
                        required><?= htmlspecialchars($project['intro']) ?></textarea>
                </div>
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
                    
                    <div class="current-image-container" id="currentImageContainer">
                        <img 
                            src="<?= htmlspecialchars(ImageHelper::getProjectImageUrl($project['image_url'])) ?>" 
                            alt="Current project image"
                            id="currentImage"
                            class="current-project-image">
                        <div class="image-overlay">
                            <span class="material-icons-round">edit</span>
                            <span>Change image</span>
                        </div>
                    </div>
                    
                    <div class="preview-container" id="previewContainer" style="display: none;">
                        <img id="imagePreview" src="" alt="Preview">
                        <button type="button" class="remove-image-btn" id="removeImageBtn">
                            <span class="material-icons-round">close</span>
                        </button>
                    </div>
                </div>
                <small class="form-hint">Click to replace image (max 5MB)</small>
            </div>
        </section>
        
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

</div>

<script src="../assets/js/project_admin.js"></script>

<?php include '../includes/footer.php'; ?>