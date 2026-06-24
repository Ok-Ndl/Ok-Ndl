<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('patient');

$pdo = getDb();
$doctors = $pdo->query('SELECT d.id, u.full_name, d.specialty FROM doctors d JOIN users u ON u.id = d.user_id ORDER BY u.full_name')->fetchAll();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = currentPatientId();
    $doctorId = (int)($_POST['doctor_id'] ?? 0);
    $appointmentDate = $_POST['appointment_date'] ?? '';
    $appointmentTime = $_POST['appointment_time'] ?? '';
    $notes = sanitize($_POST['notes'] ?? '');

    if ($patientId && $doctorId && $appointmentDate && $appointmentTime) {
        $stmt = $pdo->prepare('INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status, notes) VALUES (:patient_id, :doctor_id, :appointment_date, :appointment_time, "pending", :notes)');
        $stmt->execute(['patient_id' => $patientId, 'doctor_id' => $doctorId, 'appointment_date' => $appointmentDate, 'appointment_time' => $appointmentTime, 'notes' => $notes]);
        $message = 'Appointment request submitted successfully.';
    } else {
        $message = 'Please select a doctor, date, and time.';
    }
}
?>
<div class="card shadow-sm"><div class="card-body"><h4>Book an Appointment</h4><?php if ($message) echo '<div class="alert alert-success">' . e($message) . '</div>'; ?><form method="post" class="row g-3" data-validate="true"><div class="col-md-6"><label class="form-label">Doctor</label><select name="doctor_id" class="form-select" required><?php foreach ($doctors as $doctor) echo '<option value="' . (int)$doctor['id'] . '">' . e($doctor['full_name']) . ' - ' . e($doctor['specialty']) . '</option>'; ?></select></div><div class="col-md-6"><label class="form-label">Date</label><input type="date" name="appointment_date" class="form-control" required></div><div class="col-md-6"><label class="form-label">Time</label><input type="time" name="appointment_time" class="form-control" required></div><div class="col-12"><label class="form-label">Reason / Notes</label><textarea name="notes" class="form-control" rows="4" required></textarea></div><div class="col-12"><button class="btn btn-primary">Submit Request</button></div></form></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
