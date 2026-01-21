<form action="discovery.php" method="GET" class="flex-1">
    <div
        class="flex items-center bg-white rounded-[12px] px-[15px] h-[50px] shadow-sm transition-shadow focus-within:shadow-md md:border md:border-gray-200">
        <span class="material-icons-round text-gray-400 mr-[10px]">search</span>
        <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cerca progetti..."
            class="flex-1 min-w-0 border-none outline-none text-base text-text-dark placeholder-gray-400 bg-transparent h-full">
    </div>
    <?php if ($filterTag): ?><input type="hidden" name="tag" value="<?= htmlspecialchars($filterTag) ?>">
    <?php endif; ?>
    <?php if ($sortOrder): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sortOrder) ?>">
    <?php endif; ?>
    <?php if ($filterAvailable): ?><input type="hidden" name="available" value="1">
    <?php endif; ?>
</form>