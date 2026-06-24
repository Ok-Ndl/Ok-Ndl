<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name'] ?? '');
    $email = strtolower(sanitize($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $role = (int)($_POST['role'] ?? 3);

    if ($full_name === '' || $email === '' || strlen($password) < 6) {
        $message = 'Please complete all fields and use a password of at least 6 characters.';
    } else {
        $pdo = getDb();
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        if ($stmt->fetch()) {
            $message = 'A user with this email already exists.';
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash, role_id, status) VALUES (:full_name, :email, :password_hash, :role_id, :status)');
            $stmt->execute([
                'full_name' => $full_name,
                'email' => $email,
                'password_hash' => $hash,
                'role_id' => $role,
                'status' => 'active'
            ]);
            $_SESSION['message'] = 'Registration successful. Please log in.';
            header('Location: /Hospital_Appointment_System/auth/login.php');
            exit;
        }
    }
}
?>
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h2 class="h4 mb-3">Create an Account</h2>
        <p class="text-muted">Register as patient, doctor, or administrator.</p>
        <?php if (!empty($message)) echo '<div class="alert alert-warning">' . e($message) . '</div>'; ?>
        <form method="post" data-validate="true">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="full_name" class="form-control" required maxlength="100">
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required maxlength="100">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6" maxlength="100">
          </div>
          <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
              <option value="3">Patient</option>
              <option value="2">Doctor</option>
              <option value="1">Admin</option>
            </select>
          </div>
          <button class="btn btn-primary w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
