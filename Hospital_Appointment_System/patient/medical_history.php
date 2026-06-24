<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('patient');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Medical History</h4><table class="table table-striped"><thead><tr><th>Date</th><th>Diagnosis</th><th>Doctor</th></tr></thead><tbody><tr><td>01 Jun 2026</td><td>Routine Checkup</td><td>Dr. Smith</td></tr></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
