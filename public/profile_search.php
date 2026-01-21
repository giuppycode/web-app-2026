<?php
require_once '../includes/db.php';
include '../includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<div class="px-5 pb-[100px] mt-[80px] md:max-w-2xl md:mx-auto md:mt-[100px]">
    <h2 class="text-[1.4rem] font-bold text-gray-800 mb-[15px] mt-[10px]">Cerca Utenti</h2>

    <div class="bg-white rounded-[20px] p-[25px] shadow-sm mb-[20px] relative">
        <div class="flex items-center bg-gray-50 rounded-[12px] px-[15px] h-[50px] border border-gray-100 transition-shadow focus-within:shadow-md focus-within:bg-white focus-within:border-primary-green">
            <span class="material-icons-round text-gray-400 mr-[10px]">search</span>
            <input type="text" id="userInput" class="flex-1 border-none outline-none bg-transparent text-base text-gray-800 placeholder-gray-400" placeholder="Scrivi un username..."
                autocomplete="off">
        </div>

        <div id="resultsList" class="hidden mt-[15px] bg-white border border-gray-100 rounded-[15px] max-h-[300px] overflow-y-auto shadow-sm [&.active]:block"></div>

        <button id="addBtn" class="w-full mt-[15px] py-[12px] bg-primary-green text-white font-bold rounded-[12px] shadow-md border-none cursor-pointer transition-all hover:translate-y-[-2px] hover:shadow-lg active:scale-95 hidden" onclick="addSelectedUsers()">
            Aggiungi Selezionati
        </button>
    </div>

    <div class="bg-gray-50 rounded-[20px] p-[20px] border border-dashed border-gray-300">
        <h3 class="text-[1.1rem] font-bold text-gray-700 mb-[15px]">Utenti Selezionati:</h3>
        <div id="selectedContainer" class="flex flex-wrap gap-[10px] min-h-[40px]">
            <p class="text-gray-400 italic text-sm w-full text-center" id="emptyMsg">Nessun utente selezionato.</p>
        </div>

        <form id="finalForm">
            <input type="hidden" name="selected_ids" id="hiddenIds">
        </form>
    </div>
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
                div.className = 'flex items-center gap-[10px] p-[10px] border-b border-gray-50 last:border-0 hover:bg-gray-50 rounded-[8px] transition-colors';
                div.innerHTML = `
                    <input type="checkbox" class="w-[18px] h-[18px] accent-primary-green cursor-pointer" value="${user.id}" data-username="${user.username}" ${alreadyAdded ? 'checked disabled' : ''}>
                    <div class="w-[30px] h-[30px] rounded-full bg-gray-200 flex items-center justify-center text-gray-500"><span class="material-icons-round text-lg">person</span></div>
                    <div>
                        <div class="font-bold text-gray-800 text-sm">${user.username}</div>
                        <div class="text-xs text-gray-400">${user.email}</div>
                    </div>
                `;
                resultsList.appendChild(div);
            });
        } else {
            resultsList.classList.add('active');
            resultsList.innerHTML = '<div class="p-[15px] text-center text-gray-400 text-sm">Nessun utente trovato</div>';
            addBtn.style.display = 'none';
        }
    }

    // 3. AGGIUNGI ALLA LISTA SOTTOSTANTE
    function addSelectedUsers() {
        const checkboxes = document.querySelectorAll('#resultsList input[type="checkbox"]:checked:not(:disabled)');

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
        chip.className = 'bg-white border border-gray-200 rounded-full px-[15px] py-[5px] flex items-center gap-[8px] text-sm font-medium text-gray-700 shadow-sm transition-transform hover:shadow-md';
        chip.setAttribute('data-id', id);
        chip.innerHTML = `
            ${username}
            <span class="material-icons-round text-base text-gray-400 cursor-pointer hover:text-red-500" onclick="removeUser('${id}')">close</span>
        `;
        selectedContainer.appendChild(chip);
    }

    // 5. RIMUOVI UTENTE DALLA LISTA
    function removeUser(id) {
        selectedUsers = selectedUsers.filter(u => u.id != id);

        const chipToRemove = document.querySelector(`div[data-id="${id}"]`);
        if (chipToRemove) chipToRemove.remove();

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