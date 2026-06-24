<?php
// Purpose: Main admin dashboard showing gymnasts, statistics, and quick actions.
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

try {
    $pdo = getDbConnection();
    $gymnasts = getAllGymnasts($pdo);
    $stats = getSummaryStats($pdo);
} catch (Throwable $e) {
    $error = 'Unable to load dashboard data: ' . e($e->getMessage());
    $gymnasts = [];
    $stats = ['total' => 0, 'active' => 0, 'pending' => 0, 'completed' => 0];
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <header class="navbar container"><div class="brand">Gymnastics Admin</div><nav class="nav-links"><a href="add_gymnast.php">Add Gymnast</a><a href="../index.php">Home</a></nav></header>
  <main class="container">
    <section class="hero">
      <h1>Admin Dashboard</h1>
      <p>Search, sort, filter, update, and monitor gymnast records in a modern control panel.</p>
    </section>
    <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
    <section class="grid grid-3">
      <article class="card"><div class="stat-number"><?php echo e($stats['total']); ?></div><p>Total Gymnasts</p></article>
      <article class="card"><div class="stat-number"><?php echo e($stats['active']); ?></div><p>Active Members</p></article>
      <article class="card"><div class="stat-number"><?php echo e($stats['pending']); ?></div><p>Pending</p></article>
    </section>
    <section class="grid grid-2">
      <article class="card">
        <h3>Quick Actions</h3>
        <p><a href="add_gymnast.php">Register New Gymnast</a></p>
        <p><a href="../gymnast/profile.php?id=1">Open Sample Profile</a></p>
        <p><a href="../gymnast/profile_report.php?id=1">Generate Profile Report</a></p>
      </article>
      <article class="card">
        <h3>Recent Registrations</h3>
        <ul>
          <?php foreach (array_slice($gymnasts, 0, 5) as $row): ?><li><?php echo e($row['full_name']); ?> — <?php echo e($row['membership_id']); ?></li><?php endforeach; ?>
        </ul>
      </article>
    </section>
    <section class="table-card">
      <h3>Gymnast Records</h3>
      <div class="grid grid-3" style="margin-bottom:12px;">
        <input id="searchInput" type="search" placeholder="Search by name or status">
        <select id="programFilter"><option value="">All Programs</option><?php foreach (TRAINING_PROGRAMS as $program): ?><option value="<?php echo e($program); ?>"><?php echo e($program); ?></option><?php endforeach; ?></select>
        <select id="statusFilter"><option value="">All Status</option><?php foreach (STATUS_OPTIONS as $status): ?><option value="<?php echo e($status); ?>"><?php echo e($status); ?></option><?php endforeach; ?></select>
      </div>
      <table>
        <thead><tr><th>Name</th><th>Membership ID</th><th>Program</th><th>Status</th><th>Enrollment</th><th>Actions</th></tr></thead>
        <tbody id="gymnastTableBody">
          <?php foreach ($gymnasts as $gymnast): ?>
            <tr data-program="<?php echo e($gymnast['training_program']); ?>" data-status="<?php echo e($gymnast['status']); ?>" data-name="<?php echo e($gymnast['full_name']); ?>" data-enrollment="<?php echo e($gymnast['enrollment_date']); ?>">
              <td><?php echo e($gymnast['full_name']); ?></td>
              <td><?php echo e($gymnast['membership_id']); ?></td>
              <td><span class="badge badge-<?php echo trainingBadge($gymnast['training_program']); ?>"><?php echo e($gymnast['training_program']); ?></span></td>
              <td><span class="badge badge-<?php echo statusBadge($gymnast['status']); ?>"><?php echo e($gymnast['status']); ?></span></td>
              <td><?php echo e(formatDate($gymnast['enrollment_date'])); ?></td>
              <td class="actions"><a href="view_gymnast.php?id=<?php echo (int)$gymnast['id']; ?>">View</a> <a href="edit_gymnast.php?id=<?php echo (int)$gymnast['id']; ?>">Update</a> <a href="delete_gymnast.php?id=<?php echo (int)$gymnast['id']; ?>" onclick="return confirm('Are you sure you want to delete this gymnast?');">Delete</a></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>
  </main>
  <script src="../assets/js/dashboard.js"></script>
</body>
</html>
