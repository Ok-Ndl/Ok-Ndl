<?php
// Purpose: Securely delete a gymnast record and log the action.
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/logger.php';

$id = (int)($_GET['id'] ?? 0);
$deletedBy = 'admin';

try {
    $pdo = getDbConnection();
    $gymnast = getGymnastProfile($pdo, $id);
    if (!$gymnast) {
        throw new Exception('Gymnast not found.');
    }

    $stmt = $pdo->prepare('DELETE FROM gymnasts WHERE id = :id');
    $stmt->execute([':id' => $id]);
    appendDeleteLog($gymnast['full_name'], $gymnast['membership_id'], $deletedBy);
    header('Location: dashboard.php?deleted=1');
    exit;
} catch (Throwable $e) {
    echo 'Delete failed: ' . e($e->getMessage());
}
