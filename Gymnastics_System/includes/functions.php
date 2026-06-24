<?php
// Purpose: Reusable helper functions for rendering, formatting, and data access.
require_once __DIR__ . '/constants.php';

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function formatDate($value)
{
    return $value ? date('d M Y', strtotime($value)) : 'N/A';
}

function statusBadge($status)
{
    $map = [
        STATUS_ACTIVE => 'success',
        STATUS_ON_HOLD => 'warning',
        STATUS_COMPLETED => 'info',
        STATUS_PENDING => 'secondary',
    ];
    return $map[$status] ?? 'dark';
}

function trainingBadge($program)
{
    $map = [
        'Beginner' => 'success',
        'Intermediate' => 'info',
        'Advanced' => 'danger',
    ];
    return $map[$program] ?? 'secondary';
}

function getGymnastProfile($pdo, $id)
{
    $stmt = $pdo->prepare('SELECT * FROM gymnasts WHERE id = :id');
    $stmt->execute([':id' => (int) $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

function getAllGymnasts($pdo)
{
    $stmt = $pdo->query('SELECT * FROM gymnasts ORDER BY created_at DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getSummaryStats($pdo)
{
    $stats = [
        'total' => 0,
        'active' => 0,
        'pending' => 0,
        'completed' => 0,
    ];

    $stmt = $pdo->query('SELECT status, COUNT(*) as total FROM gymnasts GROUP BY status');
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
        $stats['total'] += (int) $row['total'];
        if ($row['status'] === STATUS_ACTIVE) $stats['active'] += (int) $row['total'];
        if ($row['status'] === STATUS_PENDING) $stats['pending'] += (int) $row['total'];
        if ($row['status'] === STATUS_COMPLETED) $stats['completed'] += (int) $row['total'];
    }
    return $stats;
}
?>
