<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

$target_id = $_GET['id'] ?? 0;

// 1. Recupero Dati Utente (Logica spostata in UserHelper)
// Funziona perfettamente anche per utenti diversi da quello loggato
$user = UserHelper::getData($db, $target_id);

if (!$user) {
    // Potresti voler fare un redirect o mostrare un errore più carino
    die("Utente non trovato.");
}

// 2. Recupero Progetti (Logica spostata in ProjectsHelper)
// Riutilizziamo la funzione getParticipating che abbiamo fatto per la Home
$projects_res = ProjectsHelper::getParticipating($db, $target_id);
?>

<div class="container">

    <div class="card"
        style="background: white; padding: 25px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 30px;">
        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
            <div
                style="width: 60px; height: 60px; background: #e0f2f1; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-green, #28a745);">
                <span class="material-icons-round" style="font-size: 30px;">person</span>
            </div>
            <div>
                <h1 style="margin: 0; font-size: 1.5rem;"><?= htmlspecialchars($user['username']) ?></h1>
                <p style="margin: 0; color: #666; font-size: 0.9rem;"><?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>

        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">

        <h3 style="font-size: 1.1rem; margin-bottom: 10px;">Bio</h3>
        <p style="color: #444; line-height: 1.6;">
            <?= nl2br(htmlspecialchars($user['biography'] ?: 'Nessuna biografia inserita.')) ?>
        </p>
    </div>

    <h3 style="margin-left: 5px; margin-bottom: 15px;">Progetti Attivi</h3>

    <?php if ($projects_res->num_rows > 0): ?>
        <ul style="list-style: none; padding: 0;">
            <?php while ($p = $projects_res->fetch_assoc()): ?>
                <li
                    style="background: white; padding: 15px 20px; border-radius: 15px; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    <div>
                        <a href="project.php?id=<?= $p['id'] ?>"
                            style="font-weight: bold; font-size: 1.1rem; color: #333; text-decoration: none; display: block;">
                            <?= htmlspecialchars($p['name']) ?>
                        </a>
                        <small style="color: #666;"><?= substr(htmlspecialchars($p['intro']), 0, 50) ?>...</small>
                    </div>

                    <span class="tag"
                        style="background: <?= $p['membership_type'] === 'founder' ? '#dcfce7' : '#f3f4f6' ?>; color: <?= $p['membership_type'] === 'founder' ? '#166534' : '#374151' ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600;">
                        <?= ucfirst($p['membership_type']) ?>
                    </span>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p style="color: #666; text-align: center; padding: 20px;">Questo utente non partecipa ancora a nessun progetto.</p>
    <?php endif; ?>

    <div style="height: 80px;"></div>
</div>

<?php include '../includes/footer.php'; ?>