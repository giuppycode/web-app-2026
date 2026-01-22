<?php
// actions/get_user_details.php

ini_set('display_errors', 0);
error_reporting(0);
require_once '../includes/db.php';
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => 'Errore sconosciuto'];

try {
    if (isset($_GET['id'])) {
        $userId = intval($_GET['id']);
        
        // 1. Prendo Dati Utente (Uso 'biography' come da DB)
       // Esempio di query corretta in get_user_details.php     
        $stmt = $db->prepare("SELECT username, biography, faculty FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        if ($user) {
            // Gestisco il NULL
            $user['biography'] = !empty($user['biography']) ? $user['biography'] : "Nessuna biografia inserita.";
            
            // 2. Prendo i TAG
            $tagsStmt = $db->prepare("SELECT t.name FROM tags t JOIN user_tags ut ON t.id = ut.tag_id WHERE ut.user_id = ?");
            $tagsStmt->bind_param("i", $userId);
            $tagsStmt->execute();
            $tagsRes = $tagsStmt->get_result();
            
            $user['tags'] = [];
            while ($row = $tagsRes->fetch_assoc()) { $user['tags'][] = $row['name']; }

            // 3. Prendo i PROGETTI
            $projStmt = $db->prepare("SELECT p.name FROM projects p JOIN project_members pm ON p.id = pm.project_id WHERE pm.user_id = ? LIMIT 5");
            $projStmt->bind_param("i", $userId);
            $projStmt->execute();
            $projRes = $projStmt->get_result();
            
            $user['projects'] = [];
            while ($row = $projRes->fetch_assoc()) { $user['projects'][] = $row['name']; }

            $response = ['success' => true, 'data' => $user];
        } else {
            $response = ['success' => false, 'message' => 'Utente non trovato'];
        }
    } else {
        $response = ['success' => false, 'message' => 'ID mancante'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Server Error: ' . $e->getMessage()];
}

echo json_encode($response);
exit;
?>