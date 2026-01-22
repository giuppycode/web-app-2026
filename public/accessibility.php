<?php
require_once '../includes/db.php';
// Includiamo l'header standard
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/accessibility-page.css?v=2">

<link rel="stylesheet" href="../assets/css/userCard.css?v=2">

<div class="acc-container">
    
    <div class="acc-header">
        <span class="material-icons-round acc-main-icon">accessibility_new</span>
        <h1>Accessibilità</h1>
        <p>Personalizza la tua esperienza su CampusLaunch</p>
    </div>

    <div class="acc-card">
        <h2>Preferenze di Visualizzazione</h2>

        <div class="acc-row">
            <div class="acc-label">
                <span class="material-icons-round">format_size</span>
                <span>Grandezza Testo</span>
            </div>
            <div class="acc-toggle-group">
                <button id="btn-text-normal" class="acc-btn" onclick="setAccessibility('text', false)">Aa</button>
                <button id="btn-text-large" class="acc-btn" onclick="setAccessibility('text', true)" style="font-size: 1.2rem;">Aa</button>
            </div>
        </div>

        <div class="acc-row">
            <div class="acc-label">
                <span class="material-icons-round">contrast</span>
                <span>Contrasto</span>
            </div>
            <div class="acc-toggle-group">
                <button id="btn-contrast-normal" class="acc-btn" onclick="setAccessibility('contrast', false)">Standard</button>
                <button id="btn-contrast-high" class="acc-btn" onclick="setAccessibility('contrast', true)">Alto</button></div>
        </div>
    </div>

    <div class="acc-card acc-text">
        <h2>Dichiarazione di Impegno</h2>
        <p>
            CampusLaunch si impegna a rendere la propria piattaforma accessibile a tutti gli studenti e founder, indipendentemente dalle loro abilità o tecnologie utilizzate.
        </p>
        <p>
            Lavoriamo costantemente per migliorare l'esperienza utente applicando gli standard di accessibilità web pertinenti.
        </p>
        
        <h3>Hai riscontrato un problema?</h3>
        <p>
            Se trovi difficoltà nell'usare questo sito, ti preghiamo di contattarci. Il tuo feedback è fondamentale per migliorare.
            <br><br>
            📧 <a href="mailto:support@campuslaunch.it" class="contact-link">support@campuslaunch.it</a>
        </p>
    </div>

    <a href="profile.php" style="display: block; text-align: center; color: #6b7280; text-decoration: none; margin-top: 20px;">
        <span class="material-icons-round" style="vertical-align: middle;">arrow_back</span> Torna al Profilo
    </a>

</div>
<script>
    // Al caricamento, illumina i bottoni se le opzioni sono attive
    document.addEventListener('DOMContentLoaded', () => {
        updateButtonsUI();
    });

    // Funzione chiamata dal CLICK dei bottoni
    function setAccessibility(type, isActive) {
        console.log("Click rilevato:", type, isActive); // Debug

        if (type === 'contrast') {
            if (isActive) {
                // Attiva visivamente subito
                document.body.classList.add('high-contrast');
                // SALVA IN MEMORIA (Chiave: highContrast)
                localStorage.setItem('highContrast', 'true');
            } else {
                document.body.classList.remove('high-contrast');
                localStorage.setItem('highContrast', 'false');
            }
        } 
        else if (type === 'text') {
            if (isActive) {
                document.body.classList.add('large-text');
                localStorage.setItem('largeText', 'true'); // Chiave: largeText
            } else {
                document.body.classList.remove('large-text');
                localStorage.setItem('largeText', 'false');
            }
        }

        // Aggiorna i colori dei bottoni
        updateButtonsUI();
    }

    function updateButtonsUI() {
        // Legge lo stato attuale
        const isHighContrast = localStorage.getItem('highContrast') === 'true';
        const isLargeText = localStorage.getItem('largeText') === 'true';

        // Gestione classi 'active' sui bottoni (per farli vedere premuti)
        // Bottoni Contrasto
        const btnContrastNorm = document.getElementById('btn-contrast-normal');
        const btnContrastHigh = document.getElementById('btn-contrast-high');
        if(btnContrastNorm) btnContrastNorm.classList.toggle('active', !isHighContrast);
        if(btnContrastHigh) btnContrastHigh.classList.toggle('active', isHighContrast);

        // Bottoni Testo
        const btnTextNorm = document.getElementById('btn-text-normal');
        const btnTextLarge = document.getElementById('btn-text-large');
        if(btnTextNorm) btnTextNorm.classList.toggle('active', !isLargeText);
        if(btnTextLarge) btnTextLarge.classList.toggle('active', isLargeText);
    }
</script>

<?php include '../includes/footer.php'; ?>