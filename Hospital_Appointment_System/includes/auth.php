<?php
require_once __DIR__ . '/session.php';
require_once __DIR__ . '/db.php';

function isLoggedIn(): bool
{
    return !empty($_SESSION['user_id']);
}

function currentUser(): ?array
{
    if (!isLoggedIn()) {
        return null;
    }

    $pdo = getDb();
    $stmt = $pdo->prepare('SELECT u.id, u.full_name, u.email, u.role_id, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE u.id = :id');
    $stmt->execute(['id' => $_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}

function currentPatientId(): ?int
{
    $user = currentUser();
    if (!$user || strtolower($user['role_name']) !== 'patient') {
        return null;
    }

    $pdo = getDb();
    $stmt = $pdo->prepare('SELECT id FROM patients WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $user['id']]);
    $row = $stmt->fetch();
    return $row ? (int)$row['id'] : null;
}

function currentDoctorId(): ?int
{
    $user = currentUser();
    if (!$user || strtolower($user['role_name']) !== 'doctor') {
        return null;
    }

    $pdo = getDb();
    $stmt = $pdo->prepare('SELECT id FROM doctors WHERE user_id = :user_id');
    $stmt->execute(['user_id' => $user['id']]);
    $row = $stmt->fetch();
    return $row ? (int)$row['id'] : null;
}

function requireLogin(): void
{
    if (!isLoggedIn()) {
        header('Location: /Hospital_Appointment_System/auth/login.php');
        exit;
    }
}

function requireRole(string $roleName): void
{
    requireLogin();
    $user = currentUser();
    if (!$user || strtolower($user['role_name']) !== strtolower($roleName)) {
        header('Location: /Hospital_Appointment_System/index.php');
        exit;
    }
}

function redirectByRole(array $user): void
{
    $role = strtolower($user['role_name']);
    if ($role === 'admin') {
        header('Location: /Hospital_Appointment_System/admin/dashboard.php');
    } elseif ($role === 'doctor') {
        header('Location: /Hospital_Appointment_System/doctor/dashboard.php');
    } else {
        header('Location: /Hospital_Appointment_System/patient/dashboard.php');
    }
    exit;
}

function sanitize(string $value): string
{
    return trim(strip_tags($value));
}

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}
?>
