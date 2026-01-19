<?php
require_once '../includes/db.php';
include '../includes/header.php';

// 1. SETUP VARIABILI E UTENTE
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Recupero parametri GET (Filtri)
$searchQuery = $_GET['q'] ?? '';
$filterTag = $_GET['tag'] ?? '';
$filterAvailable = isset($_GET['available']);
$sortOrder = $_GET['sort'] ?? 'newest';

// 2. RECUPERO I TAG PER IL MENU A TENDINA
$tagsResult = $db->query("SELECT * FROM tags ORDER BY name ASC");
$allTags = [];
if ($tagsResult) {
    while ($row = $tagsResult->fetch_assoc()) {
        $allTags[] = $row;
    }
}

// 3. COSTRUZIONE DELLA QUERY DEI PROGETTI
$sql = "SELECT DISTINCT p.*, 
        (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id AND user_id = ?) as is_starred,
        (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count
        FROM projects p 
        LEFT JOIN project_tags pt ON p.id = pt.project_id 
        LEFT JOIN tags t ON pt.tag_id = t.id";

// Preparazione condizioni WHERE
$whereConditions = [];
$params = [$user_id]; 
$types = "i";         

// A. Filtro Ricerca
if ($searchQuery) {
    $whereConditions[] = "(p.name LIKE ? OR p.intro LIKE ? OR t.name LIKE ?)";
    $searchTerm = "%" . $searchQuery . "%";
    $params[] = $searchTerm; $params[] = $searchTerm; $params[] = $searchTerm;
    $types .= "sss";
}

// B. Filtro per Tag
if ($filterTag) {
    $whereConditions[] = "pt.tag_id = ?";
    $params[] = $filterTag;
    $types .= "i";
}

// C. Filtro Posti Liberi
if ($filterAvailable) {
    $whereConditions[] = "p.occupied_slots < p.total_slots";
}

// Unione delle condizioni
if (count($whereConditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $whereConditions);
}

// D. Ordinamento
if ($sortOrder === 'stars') {
    $sql .= " ORDER BY star_count DESC, p.created_at DESC";
} else {
    $sql .= " ORDER BY p.created_at DESC";
}

// 4. ESECUZIONE QUERY
$stmt = $db->prepare($sql);
if (!$stmt) { die("Errore SQL: " . $db->error); }

$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
?>

<div class="discovery-container">

    <div class="discovery-header-row">
        <form action="discovery.php" method="GET" class="search-form-flex">
            <div class="search-wrapper">
                <span class="material-icons-round search-icon">search</span>
                <input type="text" name="q" value="<?= htmlspecialchars($searchQuery) ?>"
                    placeholder="Cerca progetti..." class="search-input-clean">
            </div>
            <?php if ($filterTag): ?><input type="hidden" name="tag" value="<?= htmlspecialchars($filterTag) ?>"><?php endif; ?>
            <?php if ($sortOrder): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sortOrder) ?>"><?php endif; ?>
            <?php if ($filterAvailable): ?><input type="hidden" name="available" value="1"><?php endif; ?>
        </form>

        <button class="filter-btn" type="button" onclick="toggleFilters()">
            <span class="material-icons-round">tune</span>
        </button>
    </div>

    <div id="filterPanel" class="filter-panel">
        <form action="discovery.php" method="GET" class="filter-form">
            <input type="hidden" name="q" value="<?= htmlspecialchars($searchQuery) ?>">

            <div class="filter-group">
                <label>Categoria</label>
                <select name="tag">
                    <option value="">Tutti i tag</option>
                    <?php foreach ($allTags as $tag): ?>
                        <option value="<?= $tag['id'] ?>" <?= $filterTag == $tag['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tag['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Ordina per</label>
                <select name="sort">
                    <option value="newest" <?= $sortOrder == 'newest' ? 'selected' : '' ?>>Più recenti</option>
                    <option value="stars" <?= $sortOrder == 'stars' ? 'selected' : '' ?>>Più popolari</option>
                </select>
            </div>

            <div class="filter-group checkbox-group">
                <label>
                    <input type="checkbox" name="available" value="1" <?= $filterAvailable ? 'checked' : '' ?>>
                    Solo posti liberi
                </label>
            </div>

            <button type="submit" class="apply-btn">Applica Filtri</button>
        </form>
    </div>

    <h2 class="section-title" style="margin-left: 5px;">
        <?php 
            if ($searchQuery) echo 'Risultati per "' . htmlspecialchars($searchQuery) . '"';
            elseif ($filterTag) echo 'Progetti filtrati';
            else echo "What's New";
        ?>
    </h2>

    <div class="vertical-list">
        <?php if ($res && $res->num_rows > 0): ?>
            <?php while ($p = $res->fetch_assoc()): ?>
                <div class="card-discovery">
                    <div class="cd-image-container">
                        <img src="https://picsum.photos/seed/<?= $p['id'] ?>/600/350" alt="Cover" class="cd-image">
                    </div>

                    <div class="cd-body">
                        <h3 class="cd-title"><?= htmlspecialchars($p['name']) ?></h3>
                        <p class="cd-desc"><?= htmlspecialchars($p['intro']) ?></p>

                        <div class="cd-stats-row">
                            <div class="cd-stat">
                                <span class="material-icons-round">group</span>
                                <span><?= $p['occupied_slots'] ?>/<?= $p['total_slots'] ?></span>
                            </div>

                            <a href="../actions/star_project.php?id=<?= $p['id'] ?>"
                                class="cd-stat star-btn <?= $p['is_starred'] ? 'active' : '' ?>">
                                <span class="material-icons-round">
                                    <?= $p['is_starred'] ? 'star' : 'star_border' ?>
                                </span>
                                <span><?= $p['star_count'] ?></span>
                            </a>
                        </div>

                        <a href="project.php?id=<?= $p['id'] ?>" class="cd-action-btn">
                            <span class="material-icons-round">person_add</span>
                            <span>Unisciti (+<?= $p['total_slots'] - $p['occupied_slots'] ?>)</span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; color: #888;">
                <p>Nessun progetto trovato.</p>
                <a href="discovery.php" style="color: green; text-decoration: underline;">Reset filtri</a>
            </div>
        <?php endif; ?>
    </div>

    <div style="height: 80px;"></div>
</div>

<script>
    function toggleFilters() {
        const panel = document.getElementById('filterPanel');
        // Aggiunge o toglie la classe 'open'
        // Il CSS farà l'animazione dell'altezza da 0 a 500px
        panel.classList.toggle('open');
    }
</script>

<?php include '../includes/footer.php'; ?>