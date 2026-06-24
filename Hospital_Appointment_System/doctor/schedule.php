<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('doctor');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Schedule Management</h4><form class="row g-3"><div class="col-md-6"><label class="form-label">Date</label><input type="date" class="form-control"></div><div class="col-md-6"><label class="form-label">Time</label><input type="time" class="form-control"></div><div class="col-12"><button class="btn btn-primary">Save Schedule</button></div></form></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
