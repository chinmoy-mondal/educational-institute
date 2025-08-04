<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'School Admin Dashboard') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  <!-- Optional: Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar -->
  <?= $this->include('layouts/admin-structure/navbar') ?>

  <!-- Sidebar -->
  <?= $this->include('layouts/admin-structure/sidebar') ?>

  <!-- Main Content -->
  <div class="content-wrapper">
    <?= $this->renderSection('content') ?>
  </div>

</div>

<!-- ✅ Scripts (jQuery first, only once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>



</body>
</html>