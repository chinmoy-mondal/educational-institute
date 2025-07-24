<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= esc($title ?? 'School Admin Dashboard') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">

  <!-- Select2 CSS --
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" rel="stylesheet" />-->
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">

  <!-- Navbar -->
  <?=  $this->include('layouts/admin-structure/navbar') ?>

  <!-- Sidebar -->
  <?= $this->include('layouts/admin-structure/sidebar') ?>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <?= $this->renderSection('content') ?>
  </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- jQuery (required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Select Subjects",
      closeOnSelect: false
    });
  });
</script>
-->
</body>
</html>
