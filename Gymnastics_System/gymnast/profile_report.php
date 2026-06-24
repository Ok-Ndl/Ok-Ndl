<?php
// Purpose: Generate a printable profile summary report for a gymnast.
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDbConnection();
$id = (int)($_GET['id'] ?? 0);
$gymnast = getGymnastProfile($pdo, $id);
if (!$gymnast) {
    die('Profile report not found.');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Profile Summary Report</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <main class="container">
    <section class="hero"><h1>Profile Summary Report</h1><p>Printable summary for <?php echo e($gymnast['full_name']); ?></p></section>
    <section class="card">
      <p><strong>Full Name:</strong> <?php echo e($gymnast['full_name']); ?></p>
      <p><strong>Membership ID:</strong> <?php echo e($gymnast['membership_id']); ?></p>
      <p><strong>Email:</strong> <?php echo e($gymnast['email']); ?></p>
      <p><strong>Date of Birth:</strong> <?php echo e(formatDate($gymnast['date_of_birth'])); ?></p>
      <p><strong>Training Program:</strong> <?php echo e($gymnast['training_program']); ?></p>
      <p><strong>Enrollment Date:</strong> <?php echo e(formatDate($gymnast['enrollment_date'])); ?></p>
      <button id="printReport" type="button">Print</button>
      <button id="downloadPdf" type="button">Download PDF</button>
    </section>
  </main>
  <script src="../assets/js/reports.js"></script>
</body>
</html>
