<?php
require_once __DIR__ . '/auth.php';
$user = currentUser();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(APP_NAME); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Hospital_Appointment_System/assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="/Hospital_Appointment_System/index.php">Hospital System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navBar">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <?php if ($user): ?>
          <li class="nav-item me-2 text-white">Welcome, <?php echo e($user['full_name']); ?> (<?php echo e($user['role_name']); ?>)</li>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="/Hospital_Appointment_System/auth/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="/Hospital_Appointment_System/auth/login.php">Login</a></li>
          <li class="nav-item ms-2"><a class="btn btn-light btn-sm" href="/Hospital_Appointment_System/auth/register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container py-4">
