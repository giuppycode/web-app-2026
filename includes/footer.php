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

    <a href="#" class="nav-item">
        <span class="material-icons-round">grid_view</span>
    </a>

    <a href="founder_panel.php" class="nav-item <?= $currentPage == 'founder_panel.php' ? 'active' : '' ?>">
        <span class="material-icons-round">local_police</span>
    </a>

    <a href="profile.php" class="nav-item <?= $currentPage == 'profile.php' ? 'active' : '' ?>">
        <span class="material-icons-round">person</span>
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
                    <span class="material-icons-round uc-menu-icon">more_vert</span>
                </div>
            </div>
        </div>

        <div class="uc-tags" id="modalTags">
            </div>

        <div class="uc-section">
            <h4>Biography</h4>
            <p id="modalBio" class="uc-text">...</p>
        </div>

        <div class="uc-section">
            <h4>Active Projects</h4>
            <div id="modalProjects" class="uc-projects-list">
                </div>
        </div>

        <button onclick="closeUserProfile(null)" class="btn-close-modal">Chiudi</button>
    </div>
</div>

<script>
    function openUserProfile(userId) {
        const modal = document.getElementById('userProfileModal');
        modal.style.display = 'flex';
        
        // Reset
        document.getElementById('modalUsername').innerText = "Caricamento...";
        document.getElementById('modalBio').innerText = "";
        document.getElementById('modalTags').innerHTML = "";
        document.getElementById('modalProjects').innerHTML = ""; 
        
        fetch('../actions/get_user_details.php?id=' + userId)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    const user = data.data;
                    
                    // Dati base
                    document.getElementById('modalUsername').innerText = user.username;
                    document.getElementById('modalBio').innerText = user.biography;
                    
                    // 1. Render Tags
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

                    // 2. Render Projects (NUOVO)
                    let projHtml = '';
                    if(user.projects && user.projects.length > 0) {
                        user.projects.forEach(projName => {
                            // Creiamo un piccolo badge o lista per i progetti
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
                document.getElementById('modalUsername').innerText = "Errore di connessione";
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