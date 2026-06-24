<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Manage Patients</h4><table class="table table-striped"><thead><tr><th>Name</th><th>Email</th><th>Status</th></tr></thead><tbody><tr><td>Jane Doe</td><td>jane@example.com</td><td>Active</td></tr></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
