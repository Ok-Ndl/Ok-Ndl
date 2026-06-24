<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('doctor');

$pdo = getDb();
$doctorId = currentDoctorId();
$appointments = [];
if ($doctorId) {
    $stmt = $pdo->prepare('SELECT a.id, a.appointment_date, a.appointment_time, a.status, u.full_name AS patient_name FROM appointments a JOIN patients p ON p.id = a.patient_id JOIN users u ON u.id = p.user_id WHERE a.doctor_id = :doctor_id ORDER BY a.appointment_date, a.appointment_time');
    $stmt->execute(['doctor_id' => $doctorId]);
    $appointments = $stmt->fetchAll();
}
?>
<div class="card shadow-sm"><div class="card-body"><h4>Appointment Management</h4><table class="table table-striped"><thead><tr><th>Patient</th><th>Date</th><th>Time</th><th>Status</th></tr></thead><tbody><?php foreach ($appointments as $item) { echo '<tr><td>' . e($item['patient_name']) . '</td><td>' . e($item['appointment_date']) . '</td><td>' . e($item['appointment_time']) . '</td><td>' . e($item['status']) . '</td></tr>'; } ?></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
