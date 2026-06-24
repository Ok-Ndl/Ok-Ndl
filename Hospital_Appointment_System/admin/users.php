<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Manage Users</h4><table class="table table-striped"><thead><tr><th>Name</th><th>Email</th><th>Role</th></tr></thead><tbody><tr><td>Admin User</td><td>admin@example.com</td><td>Admin</td></tr></tbody></table></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
