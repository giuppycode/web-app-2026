<button
    class="w-[50px] h-[50px] rounded-[12px] border-none bg-white shadow-sm flex items-center justify-center cursor-pointer text-text-dark relative transition-all flex-shrink-0 active:scale-95 hover:bg-gray-50 md:border md:border-gray-200"
    type="button" onclick="toggleFilters()">
    <span class="material-icons-round">tune</span>

    <?php if ($filterTag || $filterAvailable): ?>
        <span class="absolute top-[10px] right-[10px] w-[8px] h-[8px] bg-red-500 rounded-full border-2 border-white"></span>
    <?php endif; ?>
</button>