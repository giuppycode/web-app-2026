// assets/js/prova.js

function openUserProfile(userId) {
    const modal = document.getElementById('userProfileModal');
    
    // QUESTA È LA RIGA MAGICA CHE MANCAVA O CHE IL BROWSER NON HA AGGIORNATO
    modal.style.display = 'flex'; 

    // Reset testi
    document.getElementById('modalUsername').innerText = "Caricamento...";
    document.getElementById('modalFaculty').innerText = "";
    document.getElementById('modalBio').innerText = "";
    document.getElementById('modalProjects').innerHTML = "";

    // Chiamata AJAX
    fetch('../actions/get_user_details.php?id=' + userId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const user = data.data;
                document.getElementById('modalUsername').innerText = user.username;
                document.getElementById('modalFaculty').innerText = user.faculty || "Nessuna facoltà";
                document.getElementById('modalBio').innerText = user.biography;

                // Progetti
                const projectsContainer = document.getElementById('modalProjects');
                projectsContainer.innerHTML = ""; // Pulisci vecchi
                
                if (user.projects && user.projects.length > 0) {
                    user.projects.forEach(projName => {
                        const span = document.createElement('span');
                        span.className = 'uc-tag'; // Assicurati che questa classe esista nel CSS userCard
                        span.innerText = projName;
                        projectsContainer.appendChild(span);
                    });
                } else {
                    projectsContainer.innerHTML = "<span style='color:#999'>Nessun progetto attivo</span>";
                }
            } else {
                document.getElementById('modalUsername').innerText = "Errore";
                document.getElementById('modalBio').innerText = data.message;
            }
        })
        .catch(error => {
            console.error('Errore:', error);
            document.getElementById('modalUsername').innerText = "Errore Connessione";
        });
}

function closeUserProfile(event) {
    const modal = document.getElementById('userProfileModal');
    // Chiudi se clicchi sulla X (event null) o sull'ombra scura (event.target === modal)
    if (event === null || event.target === modal) {
        modal.style.display = 'none';
    }
}