// assets/js/accessibility-manager.js

function applyAccessibility() {
    // 1. Leggiamo la memoria (localStorage)
    // Nota: localStorage salva sempre stringhe, quindi controlliamo === 'true'
    const isHighContrast = localStorage.getItem('highContrast') === 'true';
    const isLargeText = localStorage.getItem('largeText') === 'true';

    // 2. Debug (Apri la console F12 per vedere se scrive questo messaggio)
    console.log("Accessibilità Manager -> Contrasto:", isHighContrast, "| Testo Grande:", isLargeText);

    // 3. Applicazione Classi
    if (isHighContrast) {
        document.body.classList.add('high-contrast');
    } else {
        document.body.classList.remove('high-contrast');
    }

    if (isLargeText) {
        document.body.classList.add('large-text');
    } else {
        document.body.classList.remove('large-text');
    }
}

// 4. ESEGUI SUBITO (Appena il browser legge questo file)
applyAccessibility();

// 5. Esegui anche quando la pagina è caricata del tutto (doppia sicurezza)
document.addEventListener("DOMContentLoaded", applyAccessibility);