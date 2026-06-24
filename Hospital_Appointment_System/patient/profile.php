<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('patient');
?>
<div class="card shadow-sm"><div class="card-body"><h4>Profile Management</h4><form class="row g-3" data-validate="true"><div class="col-md-6"><label class="form-label">Full Name</label><input type="text" class="form-control" required></div><div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" required></div><div class="col-12"><label class="form-label">Phone</label><input type="text" class="form-control"></div><div class="col-12"><button class="btn btn-primary">Save Profile</button></div></form></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
