<form action="discovery.php" method="GET" class="search-form-flex">
    <div class="search-wrapper">
        <span class="material-icons-round search-icon">search</span>
        <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cerca progetti..."
            class="search-input-clean">
    </div>
    <?php if ($filterTag): ?><input type="hidden" name="tag" value="<?= htmlspecialchars($filterTag) ?>">
    <?php endif; ?>
    <?php if ($sortOrder): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sortOrder) ?>">
    <?php endif; ?>
    <?php if ($filterAvailable): ?><input type="hidden" name="available" value="1">
    <?php endif; ?>
</form>