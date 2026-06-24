<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Manage Doctors</h4><table class="table table-striped"><thead><tr><th>Name</th><th>Specialty</th><th>Status</th></tr></thead><tbody><tr><td>Dr. Smith</td><td>General Medicine</td><td>Available</td></tr></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
