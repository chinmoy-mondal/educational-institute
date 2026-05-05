<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc(env('clinic.name') ?? 'Clinic System') ?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>">

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/cbc3035612.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Global Style -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f6f9fc;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(90deg, #0d6efd, #20c997);
            border: none;
        }

        /* Content spacing */
        .content {
            padding-top: 80px;
        }
    </style>

</head>

<body>