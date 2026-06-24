<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('doctor');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Medical Records</h4><form class="row g-3"><div class="col-md-6"><label class="form-label">Patient</label><input type="text" class="form-control"></div><div class="col-md-6"><label class="form-label">Diagnosis</label><input type="text" class="form-control"></div><div class="col-12"><label class="form-label">Notes</label><textarea class="form-control" rows="4"></textarea></div><div class="col-12"><button class="btn btn-primary">Save Record</button></div></form></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
