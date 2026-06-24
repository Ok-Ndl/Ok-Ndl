<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Reports</h4><p>Appointment, patient, and doctor reports are generated here.</p><ul><li>Appointment reports</li><li>Patient reports</li><li>Doctor reports</li></ul></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
