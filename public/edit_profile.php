<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
include '../includes/header.php';

// Controllo Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. Recupera Dati Utente
$user = UserHelper::getData($db, $user_id);

// 2. Recupera TUTTI i Tag disponibili nel sistema (per farli scegliere)
$allTagsQuery = $db->query("SELECT * FROM tags ORDER BY name ASC");
$allTags = $allTagsQuery->fetch_all(MYSQLI_ASSOC);

// 3. Recupera i Tag ATTUALI dell'utente (per segnarli come "checked")
$myTagsQuery = $db->prepare("SELECT tag_id FROM user_tags WHERE user_id = ?");
$myTagsQuery->bind_param("i", $user_id);
$myTagsQuery->execute();
$result = $myTagsQuery->get_result();

// Creiamo un array semplice con solo gli ID (es: [1, 5, 8])
$myTagIds = [];
while ($row = $result->fetch_assoc()) {
    $myTagIds[] = $row['tag_id'];
}
?>

<div class="container" style="max-width: 600px; margin: 0 auto;">
    
    <div style="margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;">
        <h2 class="section-title" style="margin: 0;">Modifica Profilo</h2>
        <a href="profile.php" style="color: #6b7280; text-decoration: none; font-weight: 600;">Annulla</a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div style="background:#fee2e2; color:#b91c1c; padding:12px; border-radius:12px; margin-bottom:20px;">
            ⚠️ <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <form action="../actions/update_profile.php" method="POST" class="auth-form">
        
        <div class="form-group">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="auth-input" 
                   value="<?= htmlspecialchars($user['username']) ?>" required>
            <p class="secondary-text">Questo nome sarà visibile a tutti.</p>
        </div>

        <div class="form-group">
            <label for="biography" class="form-label">Biografia</label>
            <textarea name="biography" id="biography" rows="5" class="auth-textarea"
                      placeholder="Raccontaci chi sei, cosa studi o cosa ti appassiona..."><?= htmlspecialchars($user['biography']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Le tue competenze / Interessi</label>
            <p class="secondary-text">Seleziona le aree che ti interessano:</p>
            
            <div class="tags-container">
                <?php foreach ($allTags as $tag): ?>
                    <?php $isChecked = in_array($tag['id'], $myTagIds) ? 'checked' : ''; ?>
                    
                    <label class="tag-checkbox">
                        <input type="checkbox" name="tags[]" value="<?= $tag['id'] ?>" <?= $isChecked ?>>
                        <span class ="tag-pill"><?= htmlspecialchars($tag['name']) ?></span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div style="height: 20px;"></div>

        <button type="submit" class="btn-full-width" style="background-color: var(--primary-green); color: #064e3b;">
            Salva Modifiche
        </button>

    </form>
    
    <div style="height: 100px;"></div> </div>

<?php include '../includes/footer.php'; ?>