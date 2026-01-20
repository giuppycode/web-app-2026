<?php
// includes/filter_panel_home.php

// Recupero variabili specifiche per la Home (con default sicuri)
$favSearch = $_GET['q_fav'] ?? '';
$favTag = $_GET['tag_fav'] ?? '';
$favSort = $_GET['sort_fav'] ?? 'newest';
$favAvailable = isset($_GET['available_fav']);

// Recupero tag (se non già caricati dalla pagina madre)
if (!isset($allTags) && isset($db)) {
    $allTags = ProjectsHelper::getAllTags($db);
}
?>

<div id="filterPanelHome" class="filter-panel">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
        <h3 style="margin:0; font-size: 1.1rem;">Filtra Preferiti</h3>
        <span class="material-icons-round" onclick="toggleFiltersHome()"
            style="cursor:pointer; color:#999;">close</span>
    </div>

    <form action="index.php" method="GET" class="filter-form">

        <input type="hidden" name="q_fav" value="<?= htmlspecialchars($favSearch) ?>">

        <div class="filter-group">
            <label>Categoria</label>
            <select name="tag_fav">
                <option value="">Tutti i tag</option>
                <?php foreach ($allTags as $tag): ?>
                    <option value="<?= $tag['id'] ?>" <?= $favTag == $tag['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($tag['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="filter-group">
            <label>Ordina per</label>
            <select name="sort_fav">
                <option value="newest" <?= $favSort == 'newest' ? 'selected' : '' ?>>Più recenti</option>
                <option value="stars" <?= $favSort == 'stars' ? 'selected' : '' ?>>Più popolari</option>
            </select>
        </div>

        <div class="filter-group checkbox-group">
            <label>
                <input type="checkbox" name="available_fav" value="1" <?= $favAvailable ? 'checked' : '' ?>>
                Solo posti liberi
            </label>
        </div>

        <button type="submit" class="apply-btn">Applica Filtri Home</button>
    </form>
</div>

<div id="filterOverlayHome" class="filter-overlay" onclick="toggleFiltersHome()"></div>

<script>
    function toggleFiltersHome() {
        const panel = document.getElementById('filterPanelHome');
        const overlay = document.getElementById('filterOverlayHome');

        if (panel) panel.classList.toggle('open');
        if (overlay) overlay.classList.toggle('active');
    }
</script>