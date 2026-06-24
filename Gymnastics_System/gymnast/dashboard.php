<?php
// Purpose: Interactive gymnast dashboard for browsing member profiles and training status.
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    $pdo = getDbConnection();
    $gymnasts = getAllGymnasts($pdo);
    $selected = $gymnasts[0] ?? null;
} catch (Throwable $e) {
    $error = 'Unable to load gymnast dashboard data: ' . e($e->getMessage());
    $gymnasts = [];
    $selected = null;
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gymnast Dashboard</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <header class="navbar container"><div class="brand">Gymnastics Members</div><nav class="nav-links"><a href="../admin/dashboard.php">Admin Dashboard</a><a href="../react-app/">React Demo</a><a href="../index.php">Home</a></nav></header>
  <main class="container">
    <section class="hero">
      <h1>Gymnast Dashboard</h1>
      <p>Search members, filter by program or status, and open details from the interactive cards below.</p>
    </section>
    <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>

    <section class="grid grid-3">
      <article class="card"><div class="stat-number"><?php echo e(count($gymnasts)); ?></div><p>Total Members</p></article>
      <article class="card"><div class="stat-number"><?php echo e(count(array_filter($gymnasts, fn($item) => $item['status'] === STATUS_ACTIVE))); ?></div><p>Active</p></article>
      <article class="card"><div class="stat-number"><?php echo e(count(array_filter($gymnasts, fn($item) => $item['status'] === STATUS_PENDING))); ?></div><p>Pending</p></article>
    </section>

    <section class="grid grid-2" style="align-items:start;">
      <article class="card">
        <h3>Member Explorer</h3>
        <div class="grid grid-3" style="margin-bottom:12px;">
          <input id="gymnastSearch" type="search" placeholder="Search by name or status">
          <select id="gymnastProgramFilter"><option value="">All Programs</option><?php foreach (TRAINING_PROGRAMS as $program): ?><option value="<?php echo e($program); ?>"><?php echo e($program); ?></option><?php endforeach; ?></select>
          <select id="gymnastStatusFilter"><option value="">All Status</option><?php foreach (STATUS_OPTIONS as $status): ?><option value="<?php echo e($status); ?>"><?php echo e($status); ?></option><?php endforeach; ?></select>
        </div>
        <div id="gymnastCards" class="grid grid-2">
          <?php foreach ($gymnasts as $gymnast): ?>
            <button type="button" class="feature-card gymnast-card" data-id="<?php echo (int)$gymnast['id']; ?>" data-name="<?php echo e($gymnast['full_name']); ?>" data-membership="<?php echo e($gymnast['membership_id']); ?>" data-program="<?php echo e($gymnast['training_program']); ?>" data-status="<?php echo e($gymnast['status']); ?>" data-email="<?php echo e($gymnast['email']); ?>" data-contact="<?php echo e($gymnast['contact_no']); ?>" data-dob="<?php echo e(formatDate($gymnast['date_of_birth'])); ?>" data-enrollment="<?php echo e(formatDate($gymnast['enrollment_date'])); ?>">
              <strong><?php echo e($gymnast['full_name']); ?></strong>
              <span class="chip"><?php echo e($gymnast['membership_id']); ?></span>
              <p><?php echo e($gymnast['training_program']); ?></p>
              <span class="badge badge-<?php echo statusBadge($gymnast['status']); ?>"><?php echo e($gymnast['status']); ?></span>
            </button>
          <?php endforeach; ?>
        </div>
      </article>

      <article class="card detail-panel" id="gymnastDetailPanel">
        <h3>Selected Member</h3>
        <?php if ($selected): ?>
          <h4><?php echo e($selected['full_name']); ?></h4>
          <p><strong>Membership ID:</strong> <?php echo e($selected['membership_id']); ?></p>
          <p><strong>Email:</strong> <?php echo e($selected['email']); ?></p>
          <p><strong>Contact:</strong> <?php echo e($selected['contact_no']); ?></p>
          <p><strong>Program:</strong> <span class="badge badge-<?php echo trainingBadge($selected['training_program']); ?>"><?php echo e($selected['training_program']); ?></span></p>
          <p><strong>Status:</strong> <span class="badge badge-<?php echo statusBadge($selected['status']); ?>"><?php echo e($selected['status']); ?></span></p>
          <p><strong>Date of Birth:</strong> <?php echo e(formatDate($selected['date_of_birth'])); ?></p>
          <p><strong>Enrollment Date:</strong> <?php echo e(formatDate($selected['enrollment_date'])); ?></p>
          <a class="feature-link" href="profile.php?id=<?php echo (int)$selected['id']; ?>">Open full profile</a>
        <?php else: ?>
          <p>No member data is available yet.</p>
        <?php endif; ?>
      </article>
    </section>
  </main>
  <script src="../assets/js/gymnast-dashboard.js"></script>
</body>
</html>
