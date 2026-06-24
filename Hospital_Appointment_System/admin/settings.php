<?php
require_once __DIR__ . '/../includes/header.php';
requireRole('admin');
?>
<div class="card shadow-sm"><div class="card-body"><h4>System Settings</h4><form class="row g-3"><div class="col-md-6"><label class="form-label">Clinic Name</label><input type="text" class="form-control" value="City Hospital"></div><div class="col-md-6"><label class="form-label">Contact Email</label><input type="email" class="form-control" value="support@example.com"></div><div class="col-12"><button class="btn btn-primary">Save Settings</button></div></form></div></div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
