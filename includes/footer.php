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

    <a href="#" class="nav-item">
        <span class="material-icons-round">grid_view</span>
    </a>

    <a href="founder.php" class="nav-item <?= $currentPage == 'founder.php' ? 'active' : '' ?>">
        <span class="material-icons-round">local_police</span>
    </a>

    <a href="profile.php" class="nav-item <?= $currentPage == 'profile.php' ? 'active' : '' ?>">
        <span class="material-icons-round">person</span>
    </a>

</nav>

</body>

</html>