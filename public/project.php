<?php
require_once '../includes/db.php';
require_once '../includes/ProjectsHelper.php';
include '../includes/header.php';

$project_id = $_GET['id'] ?? 0;
$project = ProjectsHelper::getDetails($db, $project_id);

if (!$project)
    die("Progetto non trovato.");

$roles = ProjectsHelper::getRoles($db, $project_id);
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-4xl md:mx-auto md:mt-[100px]">
    <div class="bg-white rounded-[20px] p-[25px] shadow-sm mb-[20px] md:p-[40px]">
        <h1 class="text-[2rem] font-bold text-gray-800 mb-[15px]"><?= htmlspecialchars($project['name']) ?></h1>
        <p class="text-[1.1rem] text-gray-600 leading-relaxed mb-[20px]">
            <?= nl2br(htmlspecialchars($project['description'])) ?></p>

        <div class="border-t border-gray-100 my-[20px]"></div>

        <h3 class="text-[1.4rem] font-bold text-gray-800 mb-[15px]">Ruoli Disponibili</h3>
        <ul class="flex flex-col gap-[10px]">
            <?php while ($role = $roles->fetch_assoc()): ?>
                <li
                    class="bg-gray-50 rounded-[12px] p-[15px] flex items-center justify-between border border-gray-100 transition-all hover:bg-gray-100">
                    <span class="text-base font-medium text-gray-700"><?= htmlspecialchars($role['role_name']) ?></span>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button onclick="alert('Richiesta inviata!')"
                            class="px-[15px] py-[8px] bg-primary-green text-white rounded-[8px] font-bold text-sm border-none cursor-pointer transition-shadow shadow-sm hover:shadow-md hover:opacity-90 active:scale-95">Candidati</button>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</div>

<?php include '../includes/footer.php'; ?>