<?php
require_once 'database.php';

// Configurazione parametri DB
$host = 'localhost';
$user = 'root';
$pass = ''; // Inserisci la tua password di MySQL
$dbname = 'webappdb';

try {
    $db = new DatabaseHelper($host, $user, $pass, $dbname);

    // 1. Gestione dell'inserimento (Operazione INSERT)
    $message = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['tag_name'])) {
        $newTagName = $_POST['tag_name'];

        try {
            $stmt = $db->prepare("INSERT INTO tags (name) VALUES (?)");
            $stmt->bind_param("s", $newTagName);
            $stmt->execute();
            $message = "✅ Tag '$newTagName' aggiunto con successo!";
        } catch (Exception $e) {
            $message = "❌ Errore durante l'inserimento: " . $e->getMessage();
        }
    }

    // 2. Recupero dei dati (Operazione SELECT)
    $projectsResult = $db->query("SELECT name, intro, total_slots FROM projects");
    $tagsResult = $db->query("SELECT name FROM tags ORDER BY id DESC");

} catch (Exception $e) {
    die("Errore di connessione: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Test WebApp DB</title>
    <style>
        body {
            font-family: sans-serif;
            max-width: 800px;
            margin: 20px auto;
            line-height: 1.6;
        }

        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
        }

        form {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <h1>🚀 Test Database WebApp</h1>

    <?php if ($message): ?>
        <p class="<?= strpos($message, '✅') !== false ? 'success' : 'error' ?>">
            <?= $message ?>
        </p>
    <?php endif; ?>

    <section>
        <h2>Aggiungi un nuovo Tag</h2>
        <form method="POST">
            <input type="text" name="tag_name" placeholder="Es: Blockchain" required>
            <button type="submit">Inserisci Tag</button>
        </form>
    </section>

    <hr>

    <section>
        <h2>Progetti nel Database</h2>
        <?php while ($row = $projectsResult->fetch_assoc()): ?>
            <div class="card">
                <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                <small><?= htmlspecialchars($row['intro']) ?></small><br>
                <span>Slot totali: <?= $row['total_slots'] ?></span>
            </div>
        <?php endwhile; ?>
    </section>

    <hr>

    <section>
        <h2>Tag Esistenti</h2>
        <ul>
            <?php while ($tag = $tagsResult->fetch_assoc()): ?>
                <li><?= htmlspecialchars($tag['name']) ?></li>
            <?php endwhile; ?>
        </ul>
    </section>

</body>

</html>

<?php
$db->close();
?>