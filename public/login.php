<?php require_once '../includes/db.php';
include '../includes/header.php'; ?>
<div class="flex flex-col items-center justify-center min-h-[calc(100vh-140px)] px-5">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Accedi a CampusLaunch</h2>
        <form action="../actions/login_action.php" method="POST" class="flex flex-col gap-5">
            <div>
                <input type="email" name="email" placeholder="Email" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary-green focus:ring-2 focus:ring-green-100 outline-none transition-all text-gray-700 bg-gray-50 focus:bg-white text-base">
            </div>
            <div>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-primary-green focus:ring-2 focus:ring-green-100 outline-none transition-all text-gray-700 bg-gray-50 focus:bg-white text-base">
            </div>
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-primary-green to-green-400 text-white rounded-xl font-bold shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all text-lg mt-2 cursor-pointer border-none">
                Entra
            </button>
        </form>
        <p class="text-center mt-6 text-gray-500 text-sm">
            Non hai ancora un account? <a href="register.php"
                class="text-primary-green font-bold no-underline hover:underline">Registrati</a>
        </p>
    </div>
</div>
<?php include '../includes/footer.php'; ?>