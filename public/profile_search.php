<?php
require_once '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: landing.php");
    exit;
}
?>

<div class="container">
    <h2 class="section-title">Cerca Utenti</h2>

    <div class="search-card">
        <div class="search-wrapper" style="margin-bottom: 0;">
            <span class="material-icons-round search-icon">search</span>
            <input type="text" id="userInput" class="search-input-clean" placeholder="Scrivi un username..."
                autocomplete="off">
        </div>

        <div id="resultsList" class="results-container"></div>

        <button id="addBtn" class="add-btn" onclick="addSelectedUsers()">
            Aggiungi Selezionati
        </button>
    </div>

    <div class="selected-users-area">
        <h3 style="font-size: 1.1rem; margin-bottom: 15px;">Utenti Selezionati:</h3>
        <div id="selectedContainer">
            <p style="color: #999; font-style: italic;" id="emptyMsg">Nessun utente selezionato.</p>
        </div>

        <form id="finalForm">
            <input type="hidden" name="selected_ids" id="hiddenIds">
        </form>
    </div>

    <div style="height: 80px;"></div>
</div>

<script>
    const input = document.getElementById('userInput');
    const resultsList = document.getElementById('resultsList');
    const addBtn = document.getElementById('addBtn');
    const selectedContainer = document.getElementById('selectedContainer');
    const emptyMsg = document.getElementById('emptyMsg');

    // Array per tenere traccia degli ID già selezionati
    let selectedUsers = [];

    // 1. ASCOLTA LA DIGITAZIONE
    input.addEventListener('input', function () {
        const query = this.value;

        // Cerca già dal PRIMO carattere (come richiesto)
        if (query.length < 1) {
            resultsList.classList.remove('active');
            addBtn.style.display = 'none';
            resultsList.innerHTML = '';
            return;
        }

        // Chiamata API
        fetch(`../actions/api_search_users.php?q=${query}`)
            .then(response => response.json())
            .then(users => {
                renderResults(users);
            });
    });

    // 2. MOSTRA I RISULTATI CON CHECKBOX
    function renderResults(users) {
        resultsList.innerHTML = '';

        if (users.length > 0) {
            resultsList.classList.add('active');
            addBtn.style.display = 'block';

            users.forEach(user => {
                const alreadyAdded = selectedUsers.some(u => u.id == user.id);

                const div = document.createElement('div');
                div.className = 'user-result-item';
                div.innerHTML = `
                    <input type="checkbox" class="user-checkbox" value="${user.id}" data-username="${user.username}" ${alreadyAdded ? 'checked disabled' : ''}>
                    <div class="user-avatar-small"><span class="material-icons-round" style="font-size: 20px;">person</span></div>
                    <div>
                        <div style="font-weight: 600;">${user.username}</div>
                        <div style="font-size: 0.8rem; color: #666;">${user.email}</div>
                    </div>
                `;
                resultsList.appendChild(div);
            });
        } else {
            resultsList.classList.add('active');
            resultsList.innerHTML = '<div style="padding:15px; text-align:center; color:#666;">Nessun utente trovato</div>';
            addBtn.style.display = 'none';
        }
    }

    // 3. AGGIUNGI ALLA LISTA SOTTOSTANTE
    function addSelectedUsers() {
        const checkboxes = document.querySelectorAll('.user-checkbox:checked:not(:disabled)');

        checkboxes.forEach(box => {
            const id = box.value;
            const username = box.getAttribute('data-username');

            selectedUsers.push({ id: id, username: username });
            createChip(id, username);
        });

        // Reset interfaccia ricerca
        input.value = '';
        resultsList.innerHTML = '';
        resultsList.classList.remove('active');
        addBtn.style.display = 'none';

        updateHiddenInput();
    }

    // 4. CREA L'ELEMENTO VISIVO (CHIP)
    function createChip(id, username) {
        if (selectedUsers.length > 0) emptyMsg.style.display = 'none';

        const chip = document.createElement('div');
        chip.className = 'selected-chip';
        chip.setAttribute('data-id', id);
        chip.innerHTML = `
            ${username}
            <span class="material-icons-round remove-chip" onclick="removeUser('${id}')">close</span>
        `;
        selectedContainer.appendChild(chip);
    }

    // 5. RIMUOVI UTENTE DALLA LISTA
    function removeUser(id) {
        selectedUsers = selectedUsers.filter(u => u.id != id);

        const chip = document.querySelector(`.selected-chip[data-id="${id}"]`);
        if (chip) chip.remove();

        if (selectedUsers.length === 0) emptyMsg.style.display = 'block';

        updateHiddenInput();
    }

    function updateHiddenInput() {
        const ids = selectedUsers.map(u => u.id).join(',');
        document.getElementById('hiddenIds').value = ids;
        console.log("ID Selezionati:", ids);
    }
</script>

<?php include '../includes/footer.php'; ?>