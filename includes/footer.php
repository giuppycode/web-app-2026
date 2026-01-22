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

<div id="userProfileModal" class="modal-overlay" onclick="closeUserProfile(event)" style="display: none;">
    <div class="user-card-modal">
        
        <div class="uc-header">
            <div class="uc-avatar-area">
                <div class="uc-avatar" id="modalAvatar">
                    <span class="material-icons-round">person</span>
                </div>
                <div class="uc-info">
                    <h3 id="modalUsername">Caricamento...</h3>
                    <p id="modalFaculty">...</p>
                </div>
            </div>
        </div>

        <div class="uc-section">
            <h4>Biography</h4>
            <p id="modalBio" class="uc-text user-bio">...</p>
        </div>

        <div class="uc-section">
            <h4>Active Projects</h4>
            <div id="modalProjects" class="uc-projects-list"></div>
        </div>

        <button onclick="closeUserProfile(null)" class="btn-close-modal">Chiudi</button>
    </div>
</div>

<script src="../assets/js/accessibility-manager.js?v=5"></script>

<script src="../assets/js/prova.js"></script>

</body>
</html>