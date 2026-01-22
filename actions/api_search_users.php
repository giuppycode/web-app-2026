<?php
require_once '../includes/db.php';
require_once '../includes/UserHelper.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit;
}

$q = $_GET['q'] ?? '';
$current_user = $_SESSION['user_id'];

if (strlen($q) < 1) {
    echo json_encode([]);
    exit;
}
$users = UserHelper::searchByUsername($db, $q, $current_user);

echo json_encode($users);
?>