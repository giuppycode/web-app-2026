<?php
require_once '../includes/db.php';
include '../includes/header.php';

// Assicuriamoci che l'utente sia loggato per calcolare le sue stelle
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Gestione Ricerca interna
$searchQuery = $_GET['q'] ?? '';
$whereClause = "";
$params = [$user_id]; // Primo parametro è sempre l'user_id per la subquery
$types = "i";         // Tipo integer per user_id

if ($searchQuery) {
    $whereClause = "WHERE p.name LIKE ? OR p.intro LIKE ? OR t.name LIKE ?";
    $searchTerm = "%" . $searchQuery . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

// QUERY AGGIORNATA:
// 1. Calcola se l'utente ha messo star (is_starred)
// 2. Conta il totale delle stelle (star_count)
$sql = "SELECT DISTINCT p.*, 
        (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id AND user_id = ?) as is_starred,
        (SELECT COUNT(*) FROM project_stars WHERE project_id = p.id) as star_count,
        GROUP_CONCAT(t.name) as tags 
        FROM projects p 
        LEFT JOIN project_tags pt ON p.id = pt.project_id 
        LEFT JOIN tags t ON pt.tag_id = t.id 
        $whereClause
        GROUP BY p.id 
        ORDER BY p.created_at DESC";

// Esecuzione query parametrica
$stmt = $db->prepare($sql);
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
        </form>
        <button class="filter-btn">
            <span class="material-icons-round">tune</span>
        </button>
    </div>

    <h2 class="section-title" style="margin-left: 5px;">
        <?= $searchQuery ? 'Risultati per "' . htmlspecialchars($searchQuery) . '"' : "What's New" ?>
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
            </div>
        <?php endif; ?>
    </div>

    <div style="height: 80px;"></div>
</div>

<?php include '../includes/footer.php'; ?>