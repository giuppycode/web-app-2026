<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// Recupero Dati
$user = UserHelper::getData($db, $user_id);

// 1. Progetti Fondati
$foundedProjects = ProjectsHelper::getFoundedProjects($db, $user_id);

// 2. Progetti Partecipati (Solo membro)
$memberProjects = ProjectsHelper::getMemberProjects($db, $user_id);

// 3. Notifiche (dai progetti fondati)
$notifications = ProjectsHelper::getFounderNotifications($db, $user_id);
?>


<div class="px-5 pb-[100px] mt-[80px] md:max-w-4xl md:mx-auto md:mt-[100px]">

    <h1 class="text-[2rem] font-bold text-gray-800 mb-[25px]">
        Welcome Founder !
    </h1>

    <a href="create_project.php"
        class="bg-gradient-to-r from-primary-green to-green-400 rounded-[25px] p-[30px] shadow-lg flex items-center justify-between mb-[30px] no-underline text-white transition-transform active:scale-[0.98] hover:shadow-xl hover:translate-y-[-3px]">
        <span class="text-[1.4rem] font-bold leading-tight">Create a new<br>project idea!</span>
        <div
            class="w-[60px] h-[60px] bg-white text-primary-green rounded-full flex items-center justify-center shadow-md">
            <span class="material-icons-round text-[32px]">add</span>
        </div>
    </a>

    <h2 class="text-[1.2rem] font-bold text-gray-600 mb-[15px] uppercase tracking-wide">Notifications</h2>
    <div class="bg-white rounded-[20px] p-[20px] shadow-sm mb-[30px] flex flex-col gap-[15px] border border-gray-100">
        <?php if ($notifications->num_rows > 0): ?>
            <?php while ($notif = $notifications->fetch_assoc()): ?>
                <div class="border-b border-gray-100 pb-[10px] last:border-0 last:pb-0">
                    <span
                        class="block text-sm font-bold text-primary-green mb-[2px]"><?= htmlspecialchars($notif['project_name']) ?></span>
                    <p class="text-[0.9rem] text-gray-600 m-0 leading-relaxed"><?= htmlspecialchars($notif['description']) ?>
                    </p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-400 italic text-center">Nessuna nuova notifica.</p>
        <?php endif; ?>
    </div>

    <h2 class="text-[1.2rem] font-bold text-gray-600 mb-[15px] uppercase tracking-wide">Your Founded Projects</h2>

    <?php if ($foundedProjects->num_rows > 0): ?>
        <div class="flex flex-col gap-[10px] mb-[30px]">
            <?php while ($p = $foundedProjects->fetch_assoc()): ?>
                <a href="project_admin.php?id=<?= $p['id'] ?>"
                    class="bg-white rounded-[15px] px-[20px] py-[15px] shadow-sm flex items-center justify-between no-underline text-text-dark border-l-[5px] border-primary-green transition-transform active:bg-gray-50 hover:shadow-md hover:translate-x-[2px]">
                    <span class="text-[1.1rem] font-bold"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">manage</span>
                </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500 mb-[20px]">Non hai ancora fondato progetti.</p>
    <?php endif; ?>

    <h2 class="text-[1.2rem] font-bold text-gray-600 mb-[15px] uppercase tracking-wide mt-[30px]">Your Participating
        Projects</h2>

    <?php if ($memberProjects->num_rows > 0): ?>
        <div class="flex flex-col gap-[10px]">
            <?php while ($p = $memberProjects->fetch_assoc()): ?>
                <a href="project.php?id=<?= $p['id'] ?>"
                    class="bg-white rounded-[15px] px-[20px] py-[15px] shadow-sm flex items-center justify-between no-underline text-text-dark border-l-[5px] border-orange-300 transition-transform active:bg-gray-50 hover:shadow-md hover:translate-x-[2px]">
                    <span class="text-[1.1rem] font-bold"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">view</span> </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-500">Non partecipi ancora a nessun progetto.</p>
    <?php endif; ?>

    <div class="h-[100px]"></div>
</div>

<?php include '../includes/footer.php'; ?>