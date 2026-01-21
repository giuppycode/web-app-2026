</div>
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

</div> <!-- End container -->
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<footer class="md:hidden">
    <nav aria-label="Navigazione principale mobile"
        class="fixed bottom-0 left-0 w-full bg-white h-[80px] flex justify-around items-center z-40 rounded-t-[25px] shadow-[0_-5px_30px_rgba(0,0,0,0.08)] pb-[10px]">

        <a href="index.php" aria-label="Vai alla Home"
            class="h-[50px] flex items-center justify-center rounded-[25px] transition-all duration-300 no-underline <?= $currentPage == 'index.php' ? 'bg-[#e8f5e9] text-primary-green px-[20px] gap-[8px]' : 'w-[50px] text-gray-400' ?>">
            <span class="material-icons-round text-2xl" aria-hidden="true">home</span>
            <?php if ($currentPage == 'index.php'): ?>
                <span class="text-sm font-bold whitespace-nowrap">Home</span>
            <?php endif; ?>
        </a>

        <a href="discovery.php" aria-label="Esplora progetti"
            class="h-[50px] flex items-center justify-center rounded-[25px] transition-all duration-300 no-underline <?= $currentPage == 'discovery.php' ? 'bg-[#e8f5e9] text-primary-green px-[20px] gap-[8px]' : 'w-[50px] text-gray-400' ?>">
            <span class="material-icons-round text-2xl" aria-hidden="true">search</span>
            <?php if ($currentPage == 'discovery.php'): ?>
                <span class="text-sm font-bold whitespace-nowrap">Discovery</span>
            <?php endif; ?>
        </a>

        <a href="create_project.php" aria-label="Crea un nuovo progetto"
            class="h-[50px] flex items-center justify-center rounded-[25px] transition-all duration-300 no-underline <?= $currentPage == 'create_project.php' ? 'bg-[#e8f5e9] text-primary-green px-[20px] gap-[8px]' : 'w-[50px] text-gray-400' ?>">
            <span class="material-icons-round text-2xl" aria-hidden="true">add</span>
            <?php if ($currentPage == 'create_project.php'): ?>
                <span class="text-sm font-bold whitespace-nowrap">Create</span>
            <?php endif; ?>
        </a>

        <a href="founder.php" aria-label="Dashboard fondatore"
            class="h-[50px] flex items-center justify-center rounded-[25px] transition-all duration-300 no-underline <?= $currentPage == 'founder.php' ? 'bg-[#e8f5e9] text-primary-green px-[20px] gap-[8px]' : 'w-[50px] text-gray-400' ?>">
            <span class="material-icons-round text-2xl" aria-hidden="true">local_florist</span>
            <?php if ($currentPage == 'founder.php'): ?>
                <span class="text-sm font-bold whitespace-nowrap">Founder</span>
            <?php endif; ?>
        </a>

        <a href="profile.php" aria-label="Visualizza profilo"
            class="h-[50px] flex items-center justify-center rounded-[25px] transition-all duration-300 no-underline <?= $currentPage == 'profile.php' ? 'bg-[#e8f5e9] text-primary-green px-[20px] gap-[8px]' : 'w-[50px] text-gray-400' ?>">
            <span class="material-icons-round text-2xl" aria-hidden="true">person</span>
            <?php if ($currentPage == 'profile.php'): ?>
                <span class="text-sm font-bold whitespace-nowrap">Profile</span>
            <?php endif; ?>
        </a>

    </nav>
</footer>

</body>

</html>