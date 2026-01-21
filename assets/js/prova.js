function openUserProfile(userId) {
    // 1. Trova la finestra modale
    const modal = document.getElementById('userProfileModal');
    if (!modal) {
        console.error("ERRORE: HTML modale non trovato nel footer!");
        return;
    }
    
    modal.style.display = 'flex';
    
    // 2. Resetta i campi
    document.getElementById('modalUsername').innerText = "Caricamento...";
    document.getElementById('modalFaculty').innerText = ""; 
    document.getElementById('modalBio').innerText = "";
    document.getElementById('modalProjects').innerHTML = ""; 
    
    // 3. Chiama il backend
    // Il percorso ../actions parte dalla cartella 'public' dove viene eseguito lo script
    fetch('../actions/get_user_details.php?id=' + userId)
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                const user = data.data;
                
                document.getElementById('modalUsername').innerText = user.username;
                
                // Mostra Facoltà
                document.getElementById('modalFaculty').innerText = user.faculty ? user.faculty : "Facoltà non specificata";

                document.getElementById('modalBio').innerText = user.biography || "Nessuna biografia.";

                // Render Projects
                let projHtml = '';
                if(user.projects && user.projects.length > 0) {
                    user.projects.forEach(projName => {
                        projHtml += `<div style="background:#f9fafb; padding:8px; border-radius:8px; margin-bottom:5px; font-size:0.9rem; border:1px solid #eee;">📂 ${projName}</div>`;
                    });
                } else {
                    projHtml = '<p class="uc-text">Nessun progetto attivo.</p>';
                }
                document.getElementById('modalProjects').innerHTML = projHtml;

            } else {
                document.getElementById('modalUsername').innerText = "Errore";
                document.getElementById('modalBio').innerText = data.message;
            }
        })
        .catch(error => {
            console.error('ERRORE JS:', error);
            document.getElementById('modalUsername').innerText = "Errore Connessione";
        });
}

function closeUserProfile(event) {
    // Chiude se clicchi fuori dalla card (sull'overlay scuro) o sul bottone chiudi
    if (!event || event.target.id === 'userProfileModal') {
        document.getElementById('userProfileModal').style.display = 'none';
    }
}