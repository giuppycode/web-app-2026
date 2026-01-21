<?php
// includes/searchbar_home.php
$q_home = $_GET['q_fav'] ?? '';
// Se c'è una ricerca attiva, aggiungiamo classi per lo stato espanso
// Usiamo una classe custom 'is-expanded' per gestire lo stato via JS, ma stilizziamo con Tailwind
$initialExpandedState = !empty($q_home) ? 'is-expanded w-full md:w-[250px]' : 'w-[40px]';
?>

<!-- 
    NOTE: Using 'group' on the wrapper to handle child styles via Tailwind might be tricky for dynamic width animation.
    We'll rely on JS toggling classes like 'w-full' vs 'w-[40px]' on the wrapper.
-->

<div id="searchHomeWrapper"
    class="relative h-[40px] bg-white rounded-[12px] shadow-sm transition-all duration-300 ease-in-out flex items-center overflow-hidden <?= $initialExpandedState ?> md:border md:border-gray-200 hover:shadow-md">
    <form action="index.php" method="GET" class="flex w-full h-full items-center m-0 p-0" onsubmit="return true;">

        <!-- Input: hidden when collapsed (w-0), expanded when open -->
        <input type="text" name="q_fav" value="<?= htmlspecialchars($q_home) ?>" placeholder="Cerca..."
            class="h-full border-none outline-none bg-transparent text-sm text-text-dark transition-all duration-300 pointer-events-none w-0 p-0 opacity-0 [&.visible]:flex-1 [&.visible]:px-3 [&.visible]:opacity-100 [&.visible]:pointer-events-auto"
            id="searchHomeInput" autocomplete="off">

        <!-- Hidden submit button for Enter key support -->
        <button type="submit" class="hidden"></button>

        <!-- Toggle/Submit Button -->
        <button type="button"
            class="w-[40px] h-[40px] border-none bg-transparent flex items-center justify-center cursor-pointer text-text-dark transition-colors hover:bg-gray-50 flex-shrink-0 z-10"
            onclick="toggleSearchHome(this)">
            <span class="material-icons-round">search</span>
        </button>
    </form>
</div>

<script>
    function toggleSearchHome(btn) {
        const wrapper = document.getElementById('searchHomeWrapper');
        const input = document.getElementById('searchHomeInput');
        const form = wrapper.querySelector('form');

        const isExpanded = wrapper.classList.contains('is-expanded');

        if (isExpanded) {
            // Se espanso, controlliamo se c'è testo
            if (input.value.trim() !== '') {
                form.submit(); // Sottometti il form
                return;
            }
            // Altrimenti, se vuoto, chiudiamo
            wrapper.classList.remove('is-expanded', 'w-full', 'md:w-[250px]');
            wrapper.classList.add('w-[40px]');
            input.classList.remove('visible');
        } else {
            // Espandi
            wrapper.classList.add('is-expanded', 'w-full', 'md:w-[250px]');
            wrapper.classList.remove('w-[40px]');
            input.classList.add('visible');
            setTimeout(() => input.focus(), 300); // Focus dopo transizione
        }
    }

    // Listener per Enter key su input per sicurezza
    document.getElementById('searchHomeInput').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Preveniamo doppio submit se necessario, ma lasciamo che il form agisca
            this.form.submit();
        }
    });

    // Init state class for input based on PHP state
    document.addEventListener('DOMContentLoaded', () => {
        const wrapper = document.getElementById('searchHomeWrapper');
        const input = document.getElementById('searchHomeInput');
        if (wrapper.classList.contains('is-expanded')) {
            input.classList.add('visible');
        }
    });
</script>