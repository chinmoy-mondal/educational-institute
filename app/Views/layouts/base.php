<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jhenaidah Public School & Collage</title>

    <link rel="stylesheet" href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>">
    <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>



    <script src="https://kit.fontawesome.com/cbc3035612.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        /* First Line (Contact & Social) */
        .top-bar {
            background: #007bff;
            color: white;
            padding: 5px 0;
            font-size: 14px;
        }

        .top-bar a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
        }

        /* Second Line (Logo & Navigation) */
        .navbar {
            background: white;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 22px;
        }

        .navbar-brand img {
            width: 60px;
            /* Set logo width */
            height: auto;
            /* Maintain aspect ratio */
            margin-right: 10px;
            /* Space between logo and text */
        }

        .navbar-toggler {
            border: none;
        }

        /* Fixed Positioning */
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .image-container img {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 10px;
            height: 300px;
        }

        .welcome-text {
            text-align: justify;
        }

        /* Push content down to avoid overlap */
        .content {
            margin-top: 150px;
            /* Adjust based on navbar height */
        }

        .course-card {
            border: 2px solid #ddd;
            /* Light border around the card */
            border-radius: 15px;
            /* Rounded corners */
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Light shadow for depth */
            text-align: center;
            background-color: #fff;
            /* White background for the card */
            overflow: hidden;
            /* Ensure the image is clipped to the rounded corners */
            position: relative;
            /* For background-image positioning */
        }

        .course-card img {
            width: 100%;
            /* Ensure the image fills the container */
            height: 100px;
            /* Fixed height */
            object-fit: cover;
            /* Cover the space without stretching */
            border-radius: 15px;
            /* Round the image corners */
            margin-bottom: 15px;
            /* Space below the image */
        }

        /* Optional background image for the card */
        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('<?= base_url('public/assets/img/ima1.jpg'); ?>');
            /* Replace with your background image */
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            /* Light opacity for subtle background image */
            border-radius: 15px;
            /* Ensure the background image has rounded corners */
            z-index: -1;
            /* Place the background behind the content */
        }

        .btn-light-custom {
            background-color: #28a745;
            /* Lighter green (adjust as needed) */
            border: 1px solid #28a745;
            /* Matching border color */
            color: white;
        }

        .btn-light-custom:hover {
            background-color: #6fda6a;
            /* A softer hover color */
            border-color: #6fda6a;
            /* Border color on hover */
            color: white;
        }

        .nav-item {
            margin-left: 20px;
            /* Adjust left spacing */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .top-bar {
                font-size: 12px;
                text-align: center;
            }

            .top-bar .d-flex {
                flex-direction: column;
                gap: 5px;
            }

            .navbar-brand img {
                width: 50px;
                /* Smaller logo on mobile */
            }

            .content {
                margin-top: 120px;
                /* Extra space for small screens */
            }
        }
    </style>
</head>

<body>


    <?= $this->rendersection("content") ?>


</body>

</html>




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