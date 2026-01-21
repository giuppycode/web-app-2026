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

<div class="px-5 pb-[100px] mt-[80px] md:max-w-2xl md:mx-auto md:mt-[100px]">
    <form action="../actions/update_profile.php" method="POST"
        class="bg-white rounded-[20px] p-[25px] shadow-sm md:p-[40px] md:shadow-md">

        <div class="flex items-center justify-between mb-[30px]">
            <a href="profile.php"
                class="flex items-center justify-center w-[40px] h-[40px] bg-gray-50 rounded-full text-text-dark no-underline shadow-sm transition-transform active:scale-95 hover:bg-gray-100">
                <span class="material-icons-round">chevron_left</span>
            </a>
            <h2 class="text-[1.3rem] font-bold text-gray-800 m-0 text-center flex-1">Update your informations</h2>
            <div class="w-[40px]"></div>
        </div>

        <h3 class="text-[0.9rem] font-bold text-gray-400 uppercase tracking-widest mb-[15px] mt-[10px]">Personal info
        </h3>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">First Name</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($user['firstname'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full"
                    placeholder="Nome">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">Last Name</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($user['lastname'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full"
                    placeholder="Cognome">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>


        <h3 class="text-[0.9rem] font-bold text-gray-400 uppercase tracking-widest mb-[15px] mt-[30px]">Contact</h3>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">Username</label>
                <input type="text" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full"
                    placeholder="Username">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">Mail</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">Phone Number</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['number'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full"
                    placeholder="+39 ...">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>

        <h3 class="text-[0.9rem] font-bold text-gray-400 uppercase tracking-widest mb-[15px] mt-[30px]">About you</h3>

        <div class="mb-[20px]">
            <label class="text-xs font-bold text-gray-400 uppercase block mb-[8px]">Biography</label>
            <div
                class="bg-gray-50 rounded-[15px] p-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all">
                <textarea name="biography"
                    class="w-full border-none bg-transparent outline-none text-base text-gray-700 resize-y min-h-[100px] font-sans placeholder-gray-300 leading-relaxed"
                    rows="4"
                    placeholder="Scrivi qualcosa su di te..."><?= htmlspecialchars($user['biography'] ?? '') ?></textarea>
            </div>
        </div>

        <div
            class="flex items-center justify-between bg-gray-50 rounded-[15px] p-[15px] mb-[15px] border border-gray-100 focus-within:bg-white focus-within:border-primary-green focus-within:shadow-sm transition-all hover:bg-gray-100 hover:focus-within:bg-white">
            <div class="flex flex-col flex-1 gap-[2px]">
                <label class="text-xs font-bold text-gray-400 uppercase">Faculty</label>
                <input type="text" name="faculty" value="<?= htmlspecialchars($user['faculty'] ?? '') ?>"
                    class="border-none bg-transparent outline-none text-[1.1rem] font-medium text-gray-800 placeholder-gray-300 w-full"
                    placeholder="Es. Informatica">
            </div>
            <span class="material-icons-round text-gray-300">edit</span>
        </div>

        <div class="mt-[20px]">
            <label class="text-xs font-bold text-gray-400 uppercase block mb-[8px]">Roles</label>
            <div class="flex flex-wrap gap-[10px]">
                <div class="bg-primary-green text-white px-[15px] py-[8px] rounded-[20px] text-sm font-bold shadow-sm">
                    Student</div>
                <div
                    class="bg-gray-100 text-gray-500 px-[15px] py-[8px] rounded-[20px] text-sm font-bold border border-gray-200">
                    Developer</div>
                <div
                    class="bg-gray-100 text-gray-500 px-[15px] py-[8px] rounded-[20px] text-sm font-bold border border-gray-200">
                    Designer</div>
            </div>
        </div>

        <div class="mt-[40px]">
            <button type="submit"
                class="w-full py-[15px] bg-primary-green text-white font-bold rounded-[15px] text-[1.1rem] border-none shadow-md shadow-green-200 cursor-pointer transition-all hover:translate-y-[-2px] hover:shadow-lg active:scale-95">Save
                Changes</button>
        </div>

    </form>
</div>

<?php include '../includes/footer.php'; ?>