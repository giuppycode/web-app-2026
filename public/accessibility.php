<?php
require_once '../includes/db.php';
// Includiamo l'header standard
include '../includes/header.php';
?>

<link rel="stylesheet" href="../assets/css/accessibility.css?v=1">

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
                <button class="acc-btn active" onclick="setAccessibility('fontSize', 'normal', this)">Aa</button>
                <button class="acc-btn" onclick="setAccessibility('fontSize', 'large', this)" style="font-size: 1.2rem;">Aa</button>
            </div>
        </div>

        <div class="acc-row">
            <div class="acc-label">
                <span class="material-icons-round">contrast</span>
                <span>Contrasto</span>
            </div>
            <div class="acc-toggle-group">
                <button class="acc-btn active" onclick="setAccessibility('contrast', 'normal', this)">Standard</button>
                <button class="acc-btn" onclick="setAccessibility('contrast', 'high', this)">Alto</button>
            </div>
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
    // 1. Al caricamento della pagina, controlliamo se ci sono preferenze salvate
    document.addEventListener('DOMContentLoaded', () => {
        const savedSize = localStorage.getItem('acc_fontSize');
        const savedContrast = localStorage.getItem('acc_contrast');

        if (savedSize === 'large') document.body.classList.add('font-large');
        if (savedContrast === 'high') document.body.classList.add('high-contrast');

        // Aggiorna visivamente i bottoni (opzionale, logica semplificata qui sotto)
        updateButtonsUI(savedSize, savedContrast);
    });

    // 2. Funzione chiamata al click dei bottoni
    function setAccessibility(type, value, btnElement) {
        // Gestione Logica CSS
        if (type === 'fontSize') {
            if (value === 'large') {
                document.body.classList.add('font-large');
                localStorage.setItem('acc_fontSize', 'large');
            } else {
                document.body.classList.remove('font-large');
                localStorage.setItem('acc_fontSize', 'normal');
            }
        } 
        else if (type === 'contrast') {
            if (value === 'high') {
                document.body.classList.add('high-contrast');
                localStorage.setItem('acc_contrast', 'high');
            } else {
                document.body.classList.remove('high-contrast');
                localStorage.setItem('acc_contrast', 'normal');
            }
        }

        // Gestione Visiva Bottoni (Sposta la classe .active)
        const parent = btnElement.parentElement;
        const buttons = parent.getElementsByClassName('acc-btn');
        for (let btn of buttons) {
            btn.classList.remove('active');
        }
        btnElement.classList.add('active');
    }

    // Funzione ausiliaria per settare i bottoni giusti al caricamento
    function updateButtonsUI(size, contrast) {
        // Questa è una logica base per evidenziare il bottone giusto se ricarichi la pagina
        // Per semplicità, in questo esempio base i bottoni tornano su "Standard" visivamente
        // ma l'effetto sulla pagina rimane.
    }
</script>

<?php include '../includes/footer.php'; ?>