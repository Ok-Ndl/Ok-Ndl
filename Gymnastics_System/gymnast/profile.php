<?php
// Purpose: Public gymnast profile page using GET id parameter.
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDbConnection();
$id = (int)($_GET['id'] ?? 0);
$gymnast = getGymnastProfile($pdo, $id);
if (!$gymnast) {
    die('Profile not found.');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gymnast Profile</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <header class="navbar container"><div class="brand">Gymnastics Profile</div><nav class="nav-links"><a href="../admin/dashboard.php">Admin</a><a href="profile_report.php?id=<?php echo $id; ?>">Report</a></nav></header>
  <main class="container">
    <section class="hero"><h1><?php echo e($gymnast['full_name']); ?></h1><p>Membership ID: <?php echo e($gymnast['membership_id']); ?></p></section>
    <section class="grid grid-2">
      <article class="card"><h3>Personal Details</h3><p><strong>Email:</strong> <?php echo e($gymnast['email']); ?></p><p><strong>Contact:</strong> <?php echo e($gymnast['contact_no']); ?></p><p><strong>DOB:</strong> <?php echo e(formatDate($gymnast['date_of_birth'])); ?></p></article>
      <article class="card"><h3>Progress Summary</h3><p><strong>Status:</strong> <span class="badge badge-<?php echo statusBadge($gymnast['status']); ?>"><?php echo e($gymnast['status']); ?></span></p><p><strong>Program:</strong> <span class="badge badge-<?php echo trainingBadge($gymnast['training_program']); ?>"><?php echo e($gymnast['training_program']); ?></span></p><p><strong>Enrollment Date:</strong> <?php echo e(formatDate($gymnast['enrollment_date'])); ?></p></article>
    </section>
  </main>
</body>
</html>
