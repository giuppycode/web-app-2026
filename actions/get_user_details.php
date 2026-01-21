<?php
// actions/get_user_details.php

// 1. Zittiamo gli errori visivi
ini_set('display_errors', 0);
error_reporting(0);

require_once '../includes/db.php';

// Header JSON
header('Content-Type: application/json; charset=utf-8');

$response = ['success' => false, 'message' => 'Errore sconosciuto'];

try {
    if (isset($_GET['id'])) {
        $userId = intval($_GET['id']);
        
        $stmt = $db->prepare("SELECT username, email, biography FROM users WHERE id = ?");
        
        if (!$stmt) {
            throw new Exception("Errore SQL User: " . $db->error);
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            
            $user['biography'] = !empty($user['biography']) ? $user['biography'] : "Nessuna biografia inserita.";
            
            // -------------------------------------------------------
            // 2. RECUPERO TAG
            // -------------------------------------------------------
            $tagsStmt = $db->prepare("
                SELECT t.name 
                FROM tags t 
                JOIN user_tags ut ON t.id = ut.tag_id 
                WHERE ut.user_id = ?
            ");
            
            if ($tagsStmt) {
                $tagsStmt->bind_param("i", $userId);
                $tagsStmt->execute();
                $tagsResult = $tagsStmt->get_result();
                
                $user['tags'] = [];
                while ($row = $tagsResult->fetch_assoc()) {
                    $user['tags'][] = $row['name'];
                }
            } else {
                $user['tags'] = []; // Fallback se la query fallisce
            }

            // -------------------------------------------------------
            // 3. RECUPERO I PROGETTI ATTIVI (Dalle tabelle projects e project_members)
            // -------------------------------------------------------
            $projStmt = $db->prepare("
                SELECT p.name 
                FROM projects p 
                JOIN project_members pm ON p.id = pm.project_id 
                WHERE pm.user_id = ?
                LIMIT 5
            ");
            
            if ($projStmt) {
                $projStmt->bind_param("i", $userId);
                $projStmt->execute();
                $projResult = $projStmt->get_result();
                
                $user['projects'] = [];
                while ($row = $projResult->fetch_assoc()) {
                    $user['projects'][] = $row['name'];
                }
            } else {
                $user['projects'] = [];
            }

            // Invio Risposta
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