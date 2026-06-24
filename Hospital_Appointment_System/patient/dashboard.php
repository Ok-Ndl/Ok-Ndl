<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('patient');
?>
<div class="mb-3"><span class="dashboard-chip">Patient Portal</span></div>
<div class="row g-4">
  <div class="col-md-6"><div class="card dashboard-card shadow-sm"><div class="card-body"><h4>Patient Dashboard</h4><p>Book appointments, review medical history, and manage profile details in a calm, supportive workspace.</p></div></div></div>
  <div class="col-md-6"><div class="card dashboard-card shadow-sm"><div class="card-body"><h4>Quick Actions</h4><ul class="list-unstyled mb-0"><li><a href="book_appointment.php">Book Appointment</a></li><li><a href="appointments.php">View Appointments</a></li><li><a href="medical_history.php">Medical History</a></li><li><a href="profile.php">Edit Profile</a></li></ul></div></div></div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
