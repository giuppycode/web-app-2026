<button class="filter-btn" type="button" onclick="toggleFilters()">
    <span class="material-icons-round">tune</span>

    <?php if ($filterTag || $filterAvailable): ?>
        <span class="filter-badge"></span>
    <?php endif; ?>
</button>