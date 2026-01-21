<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

// 1. Recupero parametri Home (Search + Filters)
$favorites = ProjectsHelper::getFavorites($db, $user_id, $_GET);

// 2. Recupero altri dati
$participating = ProjectsHelper::getParticipating($db, $user_id);
$allTags = ProjectsHelper::getAllTags($db);

// Variabili per la UI
$favTag = $_GET['tag_fav'] ?? '';
$favAvailable = isset($_GET['available_fav']);
?>

<!-- No more custom styles here, handled by Tailwind classes -->

<div class="flex justify-between items-center px-5 pt-8 mb-5 md:hidden">
    <span class="text-xl font-medium text-gray-600">Home page</span>
    <div class="relative"><span class="material-icons-round text-2xl text-text-dark">notifications</span></div>
</div>

<div class="px-5 pb-[50px] md:max-w-7xl md:mx-auto md:px-5">

    <h2 class="text-[1.4rem] font-bold mb-[15px] mt-[10px] text-gray-900">Participating</h2>
    <?php if ($participating->num_rows > 0): ?>
        <div
            class="flex gap-[15px] overflow-x-auto pb-[10px] snap-x snap-mandatory scrollbar-hide md:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:overflow-visible">
            <?php while ($p = $participating->fetch_assoc()): ?>
                <a href="project.php?id=<?= $p['id'] ?>"
                    class="block min-w-[280px] bg-white rounded-[20px] p-[20px] shadow-sm snap-center border border-transparent transition-all hover:translate-y-[-3px] hover:shadow-md md:w-full md:border-gray-200">
                    <div class="flex justify-between items-center mb-[10px]">
                        <div class="w-[30px] h-[30px] rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                            <span class="material-icons-round text-lg">person</span></div>
                        <div
                            class="text-xs text-primary-green font-bold uppercase tracking-wider bg-green-50 px-2 py-1 rounded-full">
                            <?= ucfirst($p['membership_type']) ?></div>
                        <span class="material-icons-round text-gray-400">chevron_right</span>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800 mb-[5px] truncate"><?= htmlspecialchars($p['name']) ?></h3>
                    <p class="text-sm text-gray-500 mb-[15px] leading-relaxed h-[40px] overflow-hidden">
                        <?= substr(htmlspecialchars($p['intro']), 0, 60) ?>...</p>
                    <div class="flex gap-[15px] text-sm text-gray-400">
                        <span class="flex items-center gap-[5px]"><span class="material-icons-round text-base">group</span>
                            <?= $p['member_count'] ?></span>
                        <span class="flex items-center gap-[5px]"><span class="material-icons-round text-base">star</span>
                            <?= $p['star_count'] ?></span>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <p class="text-text-muted italic">Non partecipi ancora a nessun progetto.</p>
    <?php endif; ?>

    <div class="flex justify-between items-center mt-[30px] mb-[15px]">

        <h2 class="text-[1.4rem] font-bold m-0 text-gray-900">Yours favorite</h2>

        <div class="flex items-center gap-[10px]">

            <?php include '../includes/searchbar_home.php'; ?>

            <button
                class="w-[40px] h-[40px] rounded-[12px] border-none bg-white shadow-sm flex items-center justify-center cursor-pointer text-text-dark relative transition-all active:scale-95 hover:bg-gray-50 md:border md:border-gray-200"
                type="button" onclick="toggleFiltersHome()">
                <span class="material-icons-round">tune</span>
                <?php if ($favTag || $favAvailable): ?>
                    <span
                        class="absolute top-[8px] right-[8px] w-[8px] h-[8px] bg-red-500 rounded-full border-2 border-white"></span>
                <?php endif; ?>
            </button>
        </div>
    </div>

    <?php include '../includes/filter_panel_home.php'; ?>

    <?php if (!empty($_GET['q_fav']) || $favTag || $favAvailable): ?>
        <p class="mb-[15px] text-gray-500 text-sm">
            Filtri attivi sui preferiti. <a href="index.php" class="text-primary-green font-semibold no-underline">Reset</a>
        </p>
    <?php endif; ?>

    <div class="flex flex-col gap-[15px] md:grid md:grid-cols-2 lg:grid-cols-3">
        <?php if ($favorites->num_rows > 0): ?>
            <?php while ($fav = $favorites->fetch_assoc()): ?>
                <div
                    class="bg-white rounded-[20px] p-[20px] shadow-sm border border-transparent transition-all md:border-gray-200 hover:shadow-md">
                    <div class="flex justify-between items-start mb-[15px]">
                        <h3 class="text-lg font-bold text-gray-800 m-0"><?= htmlspecialchars($fav['name']) ?></h3>
                        <div class="flex items-center gap-[5px] text-orange-400 font-bold">
                            <span class="material-icons-round text-xl">star_border</span> <?= $fav['star_count'] ?>
                        </div>
                    </div>
                    <div class="pt-[15px] border-t border-gray-100">
                        <h4 class="text-sm font-semibold text-gray-600 mb-[10px] uppercase tracking-wider">Latest news</h4>
                        <?php $news_res = ProjectsHelper::getLatestNews($db, $fav['id']); ?>
                        <?php if ($news_res->num_rows > 0): ?>
                            <ul class="list-none p-0 m-0">
                                <?php while ($news = $news_res->fetch_assoc()): ?>
                                    <li class="mb-[10px] last:mb-0">
                                        <p class="text-sm text-gray-700 m-0 leading-relaxed">
                                            <?= htmlspecialchars($news['description']) ?></p>
                                        <span class="text-xs text-gray-400 block mt-[2px]"><?= $news['date_fmt'] ?></span>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        <?php else: ?>
                            <p class="text-sm text-gray-400 italic">Nessuna news recente.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center p-5 text-gray-500 italic col-span-full">
                Nessun progetto preferito trovato con questi filtri.
            </p>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>