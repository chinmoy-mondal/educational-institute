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

  <!-- Pagination -->
  <style>
    /* Extra wrapper fix so pagination stays above table */
    .pagination {
      margin: 0 0 20px 0;
      /* bottom space so it's not covered */
      position: relative;
      /* bring it above table */
      z-index: 10;
    }

    .pagination li a {
      color: #333;
      padding: 6px 12px;
      border-radius: 4px;
      border: 1px solid #ddd;
      margin: 0 2px;
      transition: 0.2s;
      background: #fff;
      text-decoration: none !important;
    }

    .pagination li a:hover {
      background: #f1f1f1;
      text-decoration: none !important;
    }

    .pagination li.active a {
      background: #0d6efd;
      color: #fff !important;
      border-color: #0d6efd;
      pointer-events: none;
    }

    .pagination li a span {
      font-size: 14px;
    }

    /* IMPORTANT: Prevent table from hiding pagination */
    .table-responsive {
      overflow: visible !important;
    }
  </style>
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