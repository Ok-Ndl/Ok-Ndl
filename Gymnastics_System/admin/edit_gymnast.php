<?php
// Purpose: Update an existing gymnast record with validation and secure SQL.
require_once __DIR__ . '/../includes/constants.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validator.php';

$pdo = getDbConnection();
$id = (int)($_GET['id'] ?? 0);
$gymnast = getGymnastProfile($pdo, $id);
$message = '';
$error = '';

if (!$gymnast) {
    die('Gymnast not found.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
        try {
            $stmt = $pdo->prepare('UPDATE gymnasts SET full_name=:full_name, membership_id=:membership_id, email=:email, contact_no=:contact_no, date_of_birth=:date_of_birth, training_program=:training_program, enrollment_date=:enrollment_date, status=:status WHERE id=:id');
            $data['id'] = $id;
            $stmt->execute($data);
            $gymnast = getGymnastProfile($pdo, $id);
            $message = 'Gymnast updated successfully.';
        } catch (Throwable $e) {
            $error = 'Update failed: ' . e($e->getMessage());
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Gymnast</title>
  <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
  <header class="navbar container"><div class="brand">Gymnastics System</div><nav class="nav-links"><a href="dashboard.php">Dashboard</a><a href="../index.php">Home</a></nav></header>
  <main class="container">
    <section class="hero"><h1>Edit Gymnast</h1><p>Update the gymnast information and reflect changes immediately.</p></section>
    <section class="card">
      <?php if ($message): ?><div class="alert alert-success"><?php echo e($message); ?></div><?php endif; ?>
      <?php if ($error): ?><div class="alert alert-danger"><?php echo $error; ?></div><?php endif; ?>
      <form method="post">
        <label>Full Name</label><input name="full_name" value="<?php echo e($gymnast['full_name']); ?>" required>
        <label>Membership ID</label><input name="membership_id" value="<?php echo e($gymnast['membership_id']); ?>" required>
        <label>Email</label><input type="email" name="email" value="<?php echo e($gymnast['email']); ?>" required>
        <label>Contact Number</label><input name="contact_no" value="<?php echo e($gymnast['contact_no']); ?>" required>
        <label>Date of Birth</label><input type="date" name="date_of_birth" value="<?php echo e($gymnast['date_of_birth']); ?>" required>
        <label>Training Program</label>
        <select name="training_program" required>
          <?php foreach (TRAINING_PROGRAMS as $program): ?><option value="<?php echo e($program); ?>" <?php echo $program === $gymnast['training_program'] ? 'selected' : ''; ?>><?php echo e($program); ?></option><?php endforeach; ?>
        </select>
        <label>Enrollment Date</label><input type="date" name="enrollment_date" value="<?php echo e($gymnast['enrollment_date']); ?>" required>
        <label>Status</label>
        <select name="status">
          <?php foreach (STATUS_OPTIONS as $status): ?><option value="<?php echo e($status); ?>" <?php echo $status === $gymnast['status'] ? 'selected' : ''; ?>><?php echo e($status); ?></option><?php endforeach; ?>
        </select>
        <button type="submit">Update Gymnast</button>
      </form>
    </section>
  </main>
  <script src="../assets/js/validation.js"></script>
</body>
</html>
