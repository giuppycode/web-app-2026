</div>
<?php
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

</body>

</html>