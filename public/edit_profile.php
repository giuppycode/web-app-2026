<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// 1. Recupera i dati aggiornati
$user = UserHelper::getData($db, $_SESSION['user_id']);

// --- RIMOSSO IL BLOCCO "SIMULAZIONE" ---
// Non usiamo più explode() su username, usiamo i campi diretti
?>

<link rel="stylesheet" href="../assets/css/profile.css">

<div class="profile-page-container" style="background: white;">
    <form action="../actions/update_profile.php" method="POST">

        <div class="settings-header">
            <a href="profile.php" class="back-btn">
                <span class="material-icons-round">chevron_left</span>
            </a>
            <h2>Update your informations</h2>
            <div style="width: 24px;"></div>
        </div>

        <h3 class="settings-section-title">Personal info</h3>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">First Name</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user['firstname'] ?? '') ?>"
                    class="input-field-clean" placeholder="Nome">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">Last Name</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>"
                    class="input-field-clean" placeholder="Cognome">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>


        <h3 class="settings-section-title">Contact</h3>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                    class="input-field-clean" placeholder="Username">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">Mail</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                    class="input-field-clean">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">Phone Number</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['number'] ?? '') ?>"
                    class="input-field-clean" placeholder="+39 ...">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>

        <h3 class="settings-section-title">About you</h3>

        <div style="margin-bottom: 20px;">
            <label class="input-label" style="margin-bottom: 8px; display:block;">Biography</label>
            <div class="bio-container">
                <textarea name="biography" class="bio-textarea" rows="4"
                    placeholder="Scrivi qualcosa su di te..."><?= htmlspecialchars($user['biography'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="input-row">
            <div class="input-group">
                <label class="input-label">Faculty</label>
                <input type="text" name="faculty" value="<?= htmlspecialchars($user['faculty'] ?? '') ?>"
                    class="input-field-clean" placeholder="Es. Informatica">
            </div>
            <span class="material-icons-round edit-icon">edit</span>
        </div>

        <div style="margin-top: 20px;">
            <label class="input-label">Roles</label>
            <div class="roles-container">
                <div class="role-tag active">Student</div>
                <div class="role-tag">Developer</div>
                <div class="role-tag">Designer</div>
            </div>
        </div>

        <div class="save-btn-container">
            <button type="submit" class="save-btn-primary">Save Changes</button>
        </div>

    </form>
</div>

<?php include '../includes/footer.php'; ?>