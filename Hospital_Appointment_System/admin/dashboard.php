<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');

$pdo = getDb();
$totalPatients = (int)$pdo->query('SELECT COUNT(*) FROM patients')->fetchColumn();
$totalDoctors = (int)$pdo->query('SELECT COUNT(*) FROM doctors')->fetchColumn();
$totalAppointments = (int)$pdo->query('SELECT COUNT(*) FROM appointments')->fetchColumn();
$completedAppointments = (int)$pdo->query('SELECT COUNT(*) FROM appointments WHERE status = "confirmed"')->fetchColumn();
$cancelledAppointments = (int)$pdo->query('SELECT COUNT(*) FROM appointments WHERE status = "cancelled"')->fetchColumn();
?>
<div class="mb-3"><span class="dashboard-chip">Admin Portal</span></div>
<div class="row g-4">
  <div class="col-md-3"><div class="card stat-card text-center"><div class="card-body"><h5>Total Patients</h5><h2><?php echo $totalPatients; ?></h2></div></div></div>
  <div class="col-md-3"><div class="card stat-card text-center"><div class="card-body"><h5>Total Doctors</h5><h2><?php echo $totalDoctors; ?></h2></div></div></div>
  <div class="col-md-3"><div class="card stat-card text-center"><div class="card-body"><h5>Total Appointments</h5><h2><?php echo $totalAppointments; ?></h2></div></div></div>
  <div class="col-md-3"><div class="card stat-card text-center"><div class="card-body"><h5>Completed</h5><h2><?php echo $completedAppointments; ?></h2></div></div></div>
</div>
<div class="mt-4"><div class="card dashboard-card shadow-sm"><div class="card-body"><h4>Cancelled Appointments</h4><p><?php echo $cancelledAppointments; ?> appointments are currently cancelled.</p></div></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
