<div id="filterPanel"
    class="hidden w-full bg-white p-[20px] rounded-[15px] shadow-sm border border-gray-100 mb-[20px] animate-fade-in-down [&.open]:block md:block md:w-full md:mb-[30px]">
    <form action="discovery.php" method="GET"
        class="flex flex-col gap-[20px] md:flex-row md:flex-wrap md:items-end md:gap-[15px] md:bg-white md:p-[20px] md:rounded-[15px] md:shadow-sm md:border md:border-gray-100">
        <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">

        <div class="flex flex-col gap-[8px] md:flex-1 md:min-w-[200px]">
            <label class="text-sm font-bold text-gray-700">Categoria</label>
            <select name="tag"
                class="w-full text-base border-none bg-gray-100 rounded-[10px] px-[15px] h-[50px] outline-none text-text-dark appearance-none">
                <option value="">Tutti i tag</option>
                <?php foreach ($allTags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= $filterTag == $tag['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tag['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex flex-col gap-[8px] md:flex-1 md:min-w-[200px]">
            <label class="text-sm font-bold text-gray-700">Ordina per</label>
            <select name="sort"
                class="w-full text-base border-none bg-gray-100 rounded-[10px] px-[15px] h-[50px] outline-none text-text-dark appearance-none">
                <option value="newest" <?= $sortOrder == 'newest' ? 'selected' : '' ?>>Più recenti</option>
                <option value="stars" <?= $sortOrder == 'stars' ? 'selected' : '' ?>>Più popolari</option>
            </select>
        </div>

        <div class="flex items-center gap-[10px] md:h-[50px] md:mb-0">
            <label class="flex items-center gap-[10px] text-base font-medium text-text-dark cursor-pointer">
                <input type="checkbox" name="available" value="1" <?= $filterAvailable ? 'checked' : '' ?>
                    class="w-[20px] h-[20px] accent-primary-green">
                Solo posti liberi
            </label>
        </div>

        <button type="submit"
            class="w-full py-[15px] bg-primary-green text-white font-bold rounded-[12px] text-lg border-none shadow-md mt-[10px] md:w-auto md:px-[30px] md:mt-0 cursor-pointer active:scale-95 transition-transform hover:shadow-lg">Applica
            Filtri</button>
    </form>
</div>

<h2 class="text-[1.4rem] font-bold text-gray-900 ml-[5px] mb-[15px] mt-[10px]">
    <?php
    if ($searchQuery)
        echo 'Risultati per "' . htmlspecialchars($searchQuery) . '"';
    elseif ($filterTag)
        echo 'Progetti filtrati';
    ?>
</h2>

<!-- No Overlay needed for inline expansion -->

<script>
    function toggleFilters() {
        const panel = document.getElementById('filterPanel');
        if (panel) panel.classList.toggle('open');
    }
</script>