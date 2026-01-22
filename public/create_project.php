<?php
require_once '../includes/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

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

    <form action="../actions/create_project_action.php" method="POST" enctype="multipart/form-data" class="project-form">
        
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
                <label for="total_slots">Total Team Slots</label>
                <input 
                    type="number" 
                    id="total_slots" 
                    name="total_slots" 
                    class="form-input" 
                    value="5" 
                    min="1" 
                    max="50"
                    required>
                <small class="form-hint">Number of members needed (including founder)</small>
            </div>
        </section>

        <button type="submit" class="btn-launch">
            <span>Launch your project</span>
            <span class="material-icons-round">arrow_forward</span>
        </button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>