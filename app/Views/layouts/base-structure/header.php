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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f5f7fb;
        color: #1f2937;
    }

    /* global content spacing */
    .content {
        padding-top: 90px;
        padding-bottom: 50px;
    }

    /* modern card */
    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
    }

    /* smooth UI */
    a,
    button {
        transition: 0.2s;
    }
    </style>

</head>

<body>