<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('doctor');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Patient Search</h4><input type="search" class="form-control mb-3" placeholder="Search patients..."><table class="table table-striped"><thead><tr><th>Name</th><th>Email</th><th>Status</th></tr></thead><tbody><tr><td>Jane Doe</td><td>jane@example.com</td><td>Active</td></tr></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
