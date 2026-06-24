<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('patient');

$pdo = getDb();
$patientId = currentPatientId();
$appointments = [];
if ($patientId) {
    $stmt = $pdo->prepare('SELECT a.id, a.appointment_date, a.appointment_time, a.status, u.full_name AS doctor_name, d.specialty FROM appointments a JOIN doctors d ON d.id = a.doctor_id JOIN users u ON u.id = d.user_id WHERE a.patient_id = :patient_id ORDER BY a.appointment_date, a.appointment_time');
    $stmt->execute(['patient_id' => $patientId]);
    $appointments = $stmt->fetchAll();
}
?>
<div class="card shadow-sm"><div class="card-body"><h4>My Appointments</h4><select id="status-filter" class="form-select w-auto mb-3"><option value="all">All</option><option value="pending">Pending</option><option value="confirmed">Confirmed</option><option value="cancelled">Cancelled</option></select><ul id="appointment-list" class="list-group"><?php foreach ($appointments as $item) { echo '<li class="list-group-item" data-status="' . e($item['status']) . '">' . e($item['appointment_date']) . ' ' . e($item['appointment_time']) . ' - ' . e($item['doctor_name']) . ' (' . e($item['status']) . ')</li>'; } ?></ul></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
