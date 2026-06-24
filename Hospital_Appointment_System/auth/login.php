<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

if (isLoggedIn()) {
    redirectByRole(currentUser());
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(sanitize($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    $pdo = getDb();
    $stmt = $pdo->prepare('SELECT u.id, u.full_name, u.email, u.password_hash, r.name AS role_name FROM users u JOIN roles r ON r.id = u.role_id WHERE u.email = :email AND u.status = "active"');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['role_name'] = $user['role_name'];
        redirectByRole($user);
    }

    $message = 'Invalid email or password.';
}
?>
<div class="row justify-content-center">
  <div class="col-lg-5 col-md-7">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h2 class="h4 mb-3">Login</h2>
        <p class="text-muted">Access your patient, doctor, or admin dashboard.</p>
        <?php if (!empty($message)) echo '<div class="alert alert-danger">' . e($message) . '</div>'; ?>
        <?php if (!empty($_SESSION['message'])) { echo '<div class="alert alert-success">' . e($_SESSION['message']) . '</div>'; unset($_SESSION['message']); } ?>
        <form method="post" data-validate="true">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required maxlength="100">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6" maxlength="100">
          </div>
          <button class="btn btn-primary w-100">Sign In</button>
        </form>
        <p class="mt-3 text-center small text-muted">Demo credentials: patient@example.com / 123456</p>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
