<?php
// Purpose: Main landing page for the gymnastics system.
require_once __DIR__ . '/includes/constants.php';
require_once __DIR__ . '/includes/functions.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gymnastics Training System</title>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <header class="navbar container">
    <div class="brand">Gymnastics System</div>
    <nav class="nav-links">
      <a href="admin/dashboard.php">Admin Dashboard</a>
      <a href="gymnast/dashboard.php">Gymnast Dashboard</a>
      <a href="react-app/">React Demo</a>
    </nav>
  </header>

  <main class="container">
    <section class="hero">
      <h1>Gymnastics Training and Membership Management</h1>
      <p>Jump straight into the admin control panel, the live gymnast member view, or the interactive React demo.</p>
      <div class="chip-row"><span class="chip">Interactive search</span><span class="chip">Live profile cards</span><span class="chip">React demo</span></div>
    </section>

    <section class="grid grid-3">
      <a class="feature-card" href="admin/dashboard.php"><h3>Admin Dashboard</h3><p>Monitor records, filter the table, and manage gymnasts from one control panel.</p></a>
      <a class="feature-card" href="gymnast/dashboard.php"><h3>Gymnast Dashboard</h3><p>Browse member profiles, search by status, and switch between live cards instantly.</p></a>
      <a class="feature-card" href="react-app/"><h3>React Demo</h3><p>Explore the interactive React enhancement with simulated API data and member actions.</p></a>
    </section>
  </main>
</body>
</html>
