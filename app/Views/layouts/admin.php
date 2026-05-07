<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $title ?? 'Clinic Dashboard' ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f1f5f9;
    }

    .content {
        margin-left: 260px;
        padding: 25px;
    }

    .stat-card {
        background: white;
        border-radius: 18px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .stat-icon {
        font-size: 40px;
        opacity: 0.15;
        position: absolute;
        right: 15px;
        bottom: 10px;
    }

    .card {
        border-radius: 18px;
        border: none;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    /* sidebar space already handled in sidebar.php */
    </style>

</head>

<body>

    <?= $this->include('layouts/admin-structure/sidebar') ?>
    <?= $this->include('layouts/admin-structure/navbar') ?>

    <div class="content">
        <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
    </script>

</body>

</html>