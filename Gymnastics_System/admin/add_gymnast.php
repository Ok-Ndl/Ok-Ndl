<?php
// Purpose: Register a new gymnast with validation and secure database insertion.
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validator.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = getDbConnection();
        $data = [
            'full_name' => trim($_POST['full_name'] ?? ''),
            'membership_id' => trim($_POST['membership_id'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'contact_no' => trim($_POST['contact_no'] ?? ''),
            'date_of_birth' => $_POST['date_of_birth'] ?? '',
            'training_program' => $_POST['training_program'] ?? '',
            'enrollment_date' => $_POST['enrollment_date'] ?? '',
            'status' => $_POST['status'] ?? STATUS_ACTIVE,
        ];

        $errors = validateGymnastInput($data);
        if ($errors) {
            $error = implode('<br>', $errors);
        } else {
            $stmt = $pdo->prepare('INSERT INTO gymnasts (full_name, membership_id, email, contact_no, date_of_birth, training_program, enrollment_date, status) VALUES (:full_name, :membership_id, :email, :contact_no, :date_of_birth, :training_program, :enrollment_date, :status)');
            $stmt->execute($data);
            $message = 'Gymnast registered successfully.';
        }
    } catch (Throwable $e) {
        $error = 'Registration failed: ' . e($e->getMessage());
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Gymnast</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <header class="navbar container"><div class="brand">Gymnastics System</div><nav class="nav-links"><a href="dashboard.php">Dashboard</a><a href="../index.php">Home</a></nav></header>
  <main class="container">
    <section class="hero">
      <h1>Gymnast Registration</h1>
      <p>Use this form to add a gymnast to the training program.</p>
    </section>
    <section class="grid grid-2">
      <article class="card">
        <?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
        <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
        <form method="post" novalidate>
          <label>Full Name</label><input name="full_name" required>
          <label>Membership ID</label><input name="membership_id" required placeholder="MEM1004">
          <label>Email</label><input type="email" name="email" required>
          <label>Contact Number</label><input name="contact_no" required>
          <label>Date of Birth</label><input type="date" name="date_of_birth" required>
          <label>Training Program</label>
          <select name="training_program" required>
            <option value="">Select</option>
            <?php foreach (TRAINING_PROGRAMS as $program): ?><option value="<?php echo e($program); ?>"><?php echo e($program); ?></option><?php endforeach; ?>
          </select>
          <label>Enrollment Date</label><input type="date" name="enrollment_date" required>
          <label>Status</label>
          <select name="status">
            <?php foreach (STATUS_OPTIONS as $status): ?><option value="<?php echo e($status); ?>"><?php echo e($status); ?></option><?php endforeach; ?>
          </select>
          <button type="submit">Save Gymnast</button>
        </form>
      </article>
      <article class="card">
        <h3>Registration Notes</h3>
        <ul>
          <li>Prepared statements are used for safe data insertion.</li>
          <li>Input validation prevents invalid membership IDs and emails.</li>
          <li>Use the dashboard to manage records after registration.</li>
        </ul>
      </article>
    </section>
  </main>
  <script src="../assets/js/validation.js"></script>
</body>
</html>
