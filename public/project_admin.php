<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

// Controllo input
$project_id = $_GET['id'] ?? 0;
if (!$project_id)
    die("ID progetto mancante.");

$user_id = $_SESSION['user_id'];

// 1. Verifica accesso (Logica nell'Helper)
if (!ProjectsHelper::isFounder($db, $project_id, $user_id)) {
    die("Accesso negato. Solo il founder può gestire il progetto.");
}

// 2. Recupero dati (Logica nell'Helper)
$members = ProjectsHelper::getMembers($db, $project_id);
// Opzionale: Recuperiamo anche i dettagli per mostrare il titolo
$project = ProjectsHelper::getDetails($db, $project_id);
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-4xl md:mx-auto md:mt-[100px]">
    <h2 class="text-[1.8rem] font-bold text-gray-800 mb-[25px]">Gestione Progetto:
        <?= htmlspecialchars($project['name']) ?></h2>

    <div class="bg-white rounded-[20px] p-[25px] shadow-sm mb-[30px]">
        <h3 class="text-[1.2rem] font-bold text-gray-700 mb-[15px]">Membri del Team</h3>
        <ul class="flex flex-col gap-[10px]">
            <?php while ($m = $members->fetch_assoc()): ?>
                <li class="flex items-center justify-between p-[12px] bg-gray-50 rounded-[10px] border border-gray-100">
                    <span class="font-medium text-gray-800">
                        <?= htmlspecialchars($m['username']) ?>
                        <span
                            class="text-xs text-gray-500 font-normal ml-[5px] uppercase tracking-wider">(<?= $m['membership_type'] ?>)</span>
                    </span>

                    <?php if ($m['membership_type'] != 'founder'): ?>
                        <button
                            class="bg-white text-red-500 border border-red-200 rounded-[6px] px-[10px] py-[4px] text-xs font-bold cursor-pointer transition-colors hover:bg-red-50 hover:border-red-300">Rimuovi</button>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <div class="bg-white rounded-[20px] p-[25px] shadow-sm mb-[30px]">
        <h3 class="text-[1.2rem] font-bold text-gray-700 mb-[15px]">Aggiungi un Aggiornamento (News)</h3>
        <form action="../actions/post_news.php" method="POST" class="flex flex-col gap-[10px]">
            <input type="hidden" name="project_id" value="<?= $project_id ?>">
            <textarea name="news_text" placeholder="Cosa è successo di nuovo?" rows="3" required
                class="w-full bg-gray-50 border-none rounded-[15px] p-[15px] text-base font-sans resize-y min-h-[100px] outline-none transition-all placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-green-100"></textarea>
            <button type="submit"
                class="self-end bg-primary-green text-white border-none px-[20px] py-[10px] rounded-[10px] font-bold shadow-md cursor-pointer transition-transform hover:shadow-lg hover:translate-y-[-2px] active:scale-95">Pubblica
                Update</button>
        </form>
    </div>

    <div class="bg-white rounded-[20px] p-[25px] shadow-sm mb-[30px]">
        <h3 class="text-[1.2rem] font-bold text-gray-700 mb-[15px]">Gestione Ruoli Ricercati</h3>
        <form action="../actions/add_role.php" method="POST" class="flex items-center gap-[10px]">
            <input type="hidden" name="project_id" value="<?= $project_id ?>">
            <input type="text" name="role_name" placeholder="Es. UX Designer" required
                class="flex-1 bg-gray-50 border-none rounded-[10px] px-[15px] py-[12px] text-base outline-none transition-all placeholder-gray-400 focus:bg-white focus:ring-2 focus:ring-gray-200">
            <button type="submit"
                class="bg-gray-800 text-white border-none px-[20px] py-[12px] rounded-[10px] font-bold shadow-md cursor-pointer transition-transform hover:shadow-lg hover:translate-y-[-2px] active:scale-95">Aggiungi</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>