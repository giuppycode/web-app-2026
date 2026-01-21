<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php'; // Fondamentale!
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Usa Helper
$user = UserHelper::getData($db, $_SESSION['user_id']);
$stats = UserHelper::getStats($db, $_SESSION['user_id']);

if (!$user)
    die("Errore utente");
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-7xl md:mx-auto md:mt-[100px]">
    <div
        class="bg-white rounded-[20px] p-[25px] shadow-sm flex flex-col items-center mb-[20px] md:flex-row md:items-center md:justify-between md:px-[40px]">
        <div class="flex flex-col items-center mb-[25px] md:flex-row md:gap-[20px] md:mb-0">
            <div
                class="w-[80px] h-[80px] rounded-full bg-blue-100 flex items-center justify-center text-blue-500 mb-[15px] md:mb-0">
                <span class="material-icons-round text-[48px]">person</span></div>
            <div class="text-center md:text-left">
                <h2 class="text-[1.5rem] font-bold text-gray-800 m-0"><?= htmlspecialchars($user['username']) ?></h2>
                <span
                    class="inline-block px-[10px] py-[4px] rounded-full bg-purple-100 text-purple-600 font-bold text-xs uppercase tracking-wider mt-[5px]">founder</span>
            </div>
        </div>
        <div
            class="flex w-full justify-around border-t border-gray-100 pt-[20px] md:w-auto md:border-none md:pt-0 md:justify-start md:gap-[40px]">
            <div class="flex flex-col items-center md:items-start"><strong
                    class="text-[1.2rem] text-gray-800"><?= $stats['founded'] ?></strong><span
                    class="text-xs text-gray-400 uppercase tracking-widest mt-[2px]">founded</span></div>
            <div class="w-[1px] bg-gray-200 h-[40px] md:hidden"></div>
            <div class="flex flex-col items-center md:items-start"><strong
                    class="text-[1.2rem] text-gray-800"><?= $stats['starred'] ?></strong><span
                    class="text-xs text-gray-400 uppercase tracking-widest mt-[2px]">starred</span></div>
            <div class="w-[1px] bg-gray-200 h-[40px] md:hidden"></div>
            <div class="flex flex-col items-center md:items-start"><strong
                    class="text-[1.2rem] text-gray-800"><?= $stats['member'] ?></strong><span
                    class="text-xs text-gray-400 uppercase tracking-widest mt-[2px]">member</span></div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-[15px] mb-[20px] md:grid-cols-4">
        <div
            class="bg-white rounded-[20px] p-[20px] shadow-sm flex flex-col justify-center items-center text-center h-[140px] hover:shadow-md transition-shadow">
            <span
                class="text-[2.5rem] font-bold text-primary-green leading-none mb-[5px]"><?= $stats['updates'] ?></span>
            <span class="text-xs text-gray-400 leading-tight">Posted Updates<br>this week</span>
        </div>
        <div
            class="bg-white rounded-[20px] p-[20px] shadow-sm flex flex-col justify-between h-[140px] hover:shadow-md transition-shadow relative overflow-hidden">
            <div class="flex flex-col z-10">
                <span class="text-sm font-bold text-gray-700">Starred</span>
                <span class="text-[0.7rem] text-gray-400">in the past 7 days</span>
            </div>
            <div class="flex items-end justify-between h-[50px] gap-[2px]">
                <!-- Static bars for demo as per original design -->
                <div class="w-[12%] bg-green-100 rounded-t-[3px]" style="height: 40%;"></div>
                <div class="w-[12%] bg-green-200 rounded-t-[3px]" style="height: 70%;"></div>
                <div class="w-[12%] bg-green-300 rounded-t-[3px]" style="height: 30%;"></div>
                <div class="w-[12%] bg-primary-green rounded-t-[3px]" style="height: 50%;"></div>
                <div class="w-[12%] bg-green-300 rounded-t-[3px]" style="height: 80%;"></div>
                <div class="w-[12%] bg-green-200 rounded-t-[3px]" style="height: 20%;"></div>
                <div class="w-[12%] bg-green-100 rounded-t-[3px]" style="height: 60%;"></div>
            </div>
        </div>
        <!-- MD+ Spacers or extra widgets could go here -->
    </div>

    <a href="create_project.php"
        class="bg-gradient-to-r from-orange-400 to-orange-500 rounded-[20px] p-[25px] shadow-lg flex items-center gap-[20px] mb-[30px] text-white no-underline transition-transform active:scale-[0.98] hover:shadow-xl hover:translate-y-[-3px] cursor-pointer md:w-full">
        <div class="w-[50px] h-[50px] rounded-full bg-white/20 flex items-center justify-center flex-shrink-0"><span
                class="material-icons-round text-white text-2xl">local_florist</span></div>
        <div>
            <strong class="block text-lg mb-[2px]">Become a founder</strong>
            <p class="text-sm opacity-90 m-0">It's easy to launch your idea and find your team</p>
        </div>
    </a>

    <div class="flex flex-col gap-[10px] md:grid md:grid-cols-2">
        <a href="edit_profile.php"
            class="bg-white rounded-[15px] p-[20px] flex items-center justify-between shadow-sm transition-all active:bg-gray-50 no-underline text-text-dark hover:shadow-md">
            <div class="flex items-center gap-[15px] font-medium text-gray-700">
                <span class="material-icons-round text-gray-400">settings</span>
                <span>Account Settings</span>
            </div>
            <span class="material-icons-round text-gray-300">chevron_right</span>
        </a>
        <a href="../actions/logout.php"
            class="bg-white rounded-[15px] p-[20px] flex items-center justify-between shadow-sm transition-all active:bg-gray-50 no-underline text-red-500 hover:shadow-md hover:bg-red-50">
            <div class="flex items-center gap-[15px] font-medium">
                <span class="material-icons-round">logout</span>
                <span>Log out</span>
            </div>
            <span class="material-icons-round opacity-50">chevron_right</span>
        </a>
    </div>
</div>
<?php include '../includes/footer.php'; ?>