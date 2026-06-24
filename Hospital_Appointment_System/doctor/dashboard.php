<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('doctor');
?>
<div class="mb-3"><span class="dashboard-chip">Doctor Portal</span></div>
<div class="row g-4">
  <div class="col-md-6"><div class="card dashboard-card shadow-sm"><div class="card-body"><h4>Doctor Dashboard</h4><p>Review appointments, patient records, and schedule updates in a focused, premium workspace.</p></div></div></div>
  <div class="col-md-6"><div class="card dashboard-card shadow-sm"><div class="card-body"><h4>Today</h4><ul class="list-unstyled mb-0"><li>09:00 AM - Patient Checkup</li><li>11:30 AM - Follow-up</li></ul></div></div></div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
