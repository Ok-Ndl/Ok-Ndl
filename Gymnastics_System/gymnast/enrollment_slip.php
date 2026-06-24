<?php
// Purpose: Display an enrollment confirmation slip for a gymnast.
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDbConnection();
$id = (int)($_GET['id'] ?? 0);
$gymnast = getGymnastProfile($pdo, $id);
if (!$gymnast) {
    die('Enrollment slip not found.');
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Enrollment Confirmation Slip</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <main class="container">
    <section class="hero"><h1>Enrollment Confirmation Slip</h1><p>Generated for <?php echo e($gymnast['full_name']); ?></p></section>
    <section class="card">
      <p><strong>Registration Timestamp:</strong> <?php echo e($gymnast['created_at']); ?></p>
      <p><strong>Course Summary:</strong> <?php echo e($gymnast['training_program']); ?> training program.</p>
      <p><strong>Status:</strong> <?php echo e($gymnast['status']); ?></p>
      <p><strong>Membership Information:</strong> <?php echo e($gymnast['membership_id']); ?></p>
      <button id="printReport" type="button">Print</button>
      <button id="downloadPdf" type="button">Download PDF</button>
    </section>
  </main>
  <script src="../assets/js/reports.js"></script>
</body>
</html>
