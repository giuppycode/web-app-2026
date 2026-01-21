<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php'; // Fondamentale!
include '../includes/header.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Setup Variabili
$searchQuery = $_GET['q'] ?? '';
$filterTag = $_GET['tag'] ?? '';
$filterAvailable = isset($_GET['available']);
$sortOrder = $_GET['sort'] ?? 'newest';

// Usa Helper
$res = ProjectsHelper::getProjects($db, $user_id, $_GET);
$allTags = ProjectsHelper::getAllTags($db);
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-7xl md:mx-auto md:mt-[100px]">
    <div class="flex gap-[10px] mb-[20px] items-center">
        <?php include '../includes/searchbar_discovery.php'; ?>

        <?php include '../includes/filter_button.php'; ?>
    </div>

    <?php include '../includes/filter_panel.php'; ?>

    <div class="flex flex-col gap-[25px] md:grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($p = $res->fetch_assoc()): ?>
                <div
                    class="bg-white rounded-[20px] overflow-hidden shadow-md flex flex-col transition-all active:scale-[0.98] hover:translate-y-[-5px] hover:shadow-xl md:active:scale-100">
                    <div class="h-[140px] overflow-hidden bg-gray-100 relative">
                        <img src="https://picsum.photos/seed/<?= $p['id'] ?>/600/350" alt="Cover"
                            class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    </div>
                    <div class="p-[20px] flex-1 flex flex-col">
                        <h3 class="text-[1.2rem] font-bold text-gray-800 mb-[5px] line-clamp-1">
                            <?= htmlspecialchars($p['name']) ?></h3>
                        <p class="text-[0.9rem] text-gray-500 mb-[20px] h-[45px] overflow-hidden leading-relaxed line-clamp-2">
                            <?= htmlspecialchars($p['intro']) ?></p>

                        <div class="flex justify-between items-center mb-[20px] mt-auto">
                            <div class="flex items-center gap-[5px] text-gray-400 font-medium">
                                <span class="material-icons-round text-[1.2rem]">group</span>
                                <span class="text-xs"><?= $p['occupied_slots'] ?>/<?= $p['total_slots'] ?></span>
                            </div>
                            <a href="../actions/star_project.php?id=<?= $p['id'] ?>"
                                class="flex items-center gap-[5px] px-[10px] py-[5px] rounded-full text-gray-400 transition-colors hover:bg-orange-50 hover:text-orange-400 font-medium <?= $p['is_starred'] ? 'text-orange-400 font-bold' : '' ?>">
                                <span
                                    class="material-icons-round text-[1.2rem]"><?= $p['is_starred'] ? 'star' : 'star_border' ?></span>
                                <span class="text-xs"><?= $p['star_count'] ?></span>
                            </a>
                        </div>

                        <a href="project.php?id=<?= $p['id'] ?>"
                            class="flex items-center justify-center gap-[8px] px-[20px] py-[12px] rounded-xl bg-gray-100 text-gray-700 font-bold text-sm transition-all no-underline hover:bg-text-dark hover:text-white group">
                            <span class="material-icons-round transition-transform group-hover:scale-110">person_add</span>
                            <span>Unisciti</span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-span-full text-center py-[40px] text-gray-500">
                <p class="mb-4">Nessun progetto trovato.</p>
                <a href="discovery.php" class="text-primary-green font-bold no-underline hover:underline">Reset filtri</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>