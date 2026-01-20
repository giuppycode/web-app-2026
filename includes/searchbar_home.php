<?php
// includes/searchbar_home.php
$q_home = $_GET['q_fav'] ?? '';
// Se c'è una ricerca attiva, partiamo con la barra già espansa
$initialStateClass = !empty($q_home) ? 'expanded' : '';
?>

<div id="searchHomeWrapper" class="search-expand-wrapper <?= $initialStateClass ?>">
    <form action="index.php" method="GET" style="display: flex; width: 100%; align-items: center;">

        <input type="text" name="q_fav" value="<?= htmlspecialchars($q_home) ?>" placeholder="Cerca..."
            class="search-input-expanded" id="searchHomeInput">

        <button type="button" class="search-trigger-btn" onclick="toggleSearchHome()">
            <span class="material-icons-round">search</span>
        </button>
    </form>
</div>

<script>
    function toggleSearchHome() {
        const wrapper = document.getElementById('searchHomeWrapper');
        const input = document.getElementById('searchHomeInput');

        // Toggle della classe che fa partire l'animazione CSS
        wrapper.classList.toggle('expanded');

        // Se abbiamo appena aperto, diamo il focus per scrivere subito
        if (wrapper.classList.contains('expanded')) {
            input.focus();
        }
    }
</script>