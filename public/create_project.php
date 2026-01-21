<?php
require_once '../includes/db.php';
include '../includes/header.php';
if (!isset($_SESSION['user_id']))
    header("Location: login.php");
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-2xl md:mx-auto md:mt-[100px]">
    <div class="bg-white rounded-[20px] p-[25px] shadow-sm md:p-[40px] md:shadow-md">
        <h2 class="text-[1.8rem] font-bold text-gray-800 mb-[25px] text-center md:text-left">Lancia la tua Idea 🚀</h2>

        <form action="../actions/create_project_action.php" method="POST" class="flex flex-col gap-[20px]">
            <div class="flex flex-col gap-[8px]">
                <label class="text-sm font-bold text-gray-700 ml-[5px]">Titolo del Progetto</label>
                <input type="text" name="name" placeholder="Es: CollabLearn" required
                    class="w-full px-[15px] py-[12px] bg-gray-50 border border-gray-200 rounded-[12px] text-base text-gray-800 outline-none transition-all focus:border-primary-green focus:bg-white focus:ring-2 focus:ring-green-100 placeholder-gray-400">
            </div>

            <div class="flex flex-col gap-[8px]">
                <label class="text-sm font-bold text-gray-700 ml-[5px]">Breve Introduzione</label>
                <input type="text" name="intro" maxlength="255" placeholder="Una frase che colpisca" required
                    class="w-full px-[15px] py-[12px] bg-gray-50 border border-gray-200 rounded-[12px] text-base text-gray-800 outline-none transition-all focus:border-primary-green focus:bg-white focus:ring-2 focus:ring-green-100 placeholder-gray-400">
            </div>

            <div class="flex flex-col gap-[8px]">
                <label class="text-sm font-bold text-gray-700 ml-[5px]">Descrizione Completa</label>
                <textarea name="description" rows="5" placeholder="Spiega la tua visione nel dettaglio" required
                    class="w-full px-[15px] py-[12px] bg-gray-50 border border-gray-200 rounded-[12px] text-base text-gray-800 outline-none transition-all focus:border-primary-green focus:bg-white focus:ring-2 focus:ring-green-100 resize-y min-h-[120px] placeholder-gray-400 font-sans"></textarea>
            </div>

            <div class="flex flex-col gap-[8px]">
                <label class="text-sm font-bold text-gray-700 ml-[5px]">Slot Totali (Membri necessari)</label>
                <input type="number" name="total_slots" value="2" min="1"
                    class="w-full px-[15px] py-[12px] bg-gray-50 border border-gray-200 rounded-[12px] text-base text-gray-800 outline-none transition-all focus:border-primary-green focus:bg-white focus:ring-2 focus:ring-green-100">
            </div>

            <button type="submit"
                class="w-full py-[15px] bg-gradient-to-r from-primary-green to-green-400 text-white rounded-[15px] font-bold text-[1.1rem] shadow-md mt-[10px] cursor-pointer transition-all border-none hover:shadow-lg hover:translate-y-[-2px] active:scale-[0.98]">
                Crea Progetto
            </button>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>