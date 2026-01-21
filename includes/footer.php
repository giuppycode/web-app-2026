</div> <?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="bottom-nav">
    <a href="index.php" class="nav-item <?= $currentPage == 'index.php' ? 'active' : '' ?>">
        <span class="material-icons-round">home</span>
        <span class="label">Home</span>
    </a>
    <a href="discovery.php" class="nav-item <?= $currentPage == 'discovery.php' ? 'active' : '' ?>">
        <span class="material-icons-round">search</span>
        <span class="label">Discovery</span>
    </a>
    <a href="create_project.php" class="nav-item <?= $currentPage == 'create_project.php' ? 'active' : '' ?>">
        <span class="material-icons-round">add</span>
        <span class="label">Create</span>
    </a>
    <a href="founder.php" class="nav-item <?= $currentPage == 'founder.php' ? 'active' : '' ?>">
        <span class="material-icons-round">local_florist</span>
        <span class="label">Founder</span>
    </a>
    <a href="profile.php" class="nav-item <?= $currentPage == 'profile.php' ? 'active' : '' ?>">
        <span class="material-icons-round">person</span>
        <span class="label">Profile</span>
    </a>
</nav>

<div id="userProfileModal" class="modal-overlay" onclick="closeUserProfile(event)">
    <div class="user-card-modal">
        
        <div class="uc-header">
            <div class="uc-avatar-area">
                <div class="uc-avatar" id="modalAvatar">
                    <span class="material-icons-round">person</span>
                </div>
                <div class="uc-info">
                    <h3 id="modalUsername">Caricamento...</h3>
                </div>
            </div>
        </div>

        <div class="uc-tags" id="modalTags"></div>

        <div class="uc-section">
            <h4>Biography</h4>
            <p id="modalBio" class="uc-text">...</p>
        </div>

        <div class="uc-section">
            <h4>Active Projects</h4>
            <div id="modalProjects" class="uc-projects-list"></div>
        </div>

        <button onclick="closeUserProfile(null)" class="btn-close-modal">Chiudi</button>
    </div>
</div>

<script>
    function openUserProfile(userId) {
        // 1. Trova la finestra modale (Se questo è null, non funzionerà nulla)
        const modal = document.getElementById('userProfileModal');
        if (!modal) {
            console.error("ERRORE: HTML modale non trovato nel footer!");
            return;
        }
        
        modal.style.display = 'flex';
        
        // 2. Resetta i campi
        document.getElementById('modalUsername').innerText = "Caricamento...";
        document.getElementById('modalBio').innerText = "";
        document.getElementById('modalTags').innerHTML = "";
        document.getElementById('modalProjects').innerHTML = ""; 
        
        // 3. Chiama il backend
        fetch('../actions/get_user_details.php?id=' + userId)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const user = data.data;
                    
                    document.getElementById('modalUsername').innerText = user.username;
                    // NOTA: Qui uso user.biography perché è così che si chiama nel DB
                    document.getElementById('modalBio').innerText = user.biography || "Nessuna biografia.";
                    
                    // Render Tags
                    let tagsHtml = '';
                    if(user.tags && user.tags.length > 0) {
                        const colors = ['tag-blue', 'tag-green', 'tag-orange'];
                        user.tags.forEach((tag, index) => {
                            const colorClass = colors[index % colors.length];
                            tagsHtml += `<span class="uc-tag ${colorClass}">${tag}</span>`;
                        });
                    } else {
                        tagsHtml = '<span style="color:#999; font-size:0.8rem;">Nessun tag</span>';
                    }
                    document.getElementById('modalTags').innerHTML = tagsHtml;

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
        if (!event || event.target.id === 'userProfileModal') {
            document.getElementById('userProfileModal').style.display = 'none';
        }
    }
</script>

</body>
</html>