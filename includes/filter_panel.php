<div id="filterPanel" class="filter-panel">
    <form action="discovery.php" method="GET" class="filter-form">
        <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">

        <div class="filter-group">
            <label>Categoria</label>
            <select name="tag">
                <option value="">Tutti i tag</option>
                <?php foreach ($allTags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= $filterTag == $tag['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tag['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label>Ordina per</label>
            <select name="sort">
                <option value="newest" <?= $sortOrder == 'newest' ? 'selected' : '' ?>>Più recenti</option>
                <option value="stars" <?= $sortOrder == 'stars' ? 'selected' : '' ?>>Più popolari</option>
            </select>
        </div>

        <div class="filter-group checkbox-group">
            <label>
                <input type="checkbox" name="available" value="1" <?= $filterAvailable ? 'checked' : '' ?>>
                Solo posti liberi
            </label>
        </div>

        <button type="submit" class="apply-btn">Applica Filtri</button>
    </form>
</div>

<h2 class="section-title" style="margin-left: 5px;">
    <?php
    if ($searchQuery)
        echo 'Risultati per "' . htmlspecialchars($searchQuery) . '"';
    elseif ($filterTag)
        echo 'Progetti filtrati';
    else
        echo "What's New";
    ?>
</h2>

<div id="filterOverlay" class="filter-overlay" onclick="toggleFilters()"></div>

<script>
    function toggleFilters() {
        const panel = document.getElementById('filterPanel');
        const overlay = document.getElementById('filterOverlay');

        // CORREZIONE: Usa 'open' perché nel tuo mobile.css hai scritto .filter-panel.open
        if (panel) panel.classList.toggle('open');

        // L'overlay usa ancora 'active' nel CSS
        if (overlay) overlay.classList.toggle('active');
    }
</script>