<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Fixed Two-Line Navbar</title>
        <link href="<?= base_url('public/assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
        <script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js'); ?>"></script>
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
                width: 60px;  /* Set logo width */
                height: auto; /* Maintain aspect ratio */
                margin-right: 10px; /* Space between logo and text */
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

            /* Push content down to avoid overlap */
            .content {
                margin-top: 150px; /* Adjust based on navbar height */
            }
            .course-card {
                border: 2px solid #ddd;  /* Light border around the card */
                border-radius: 15px;      /* Rounded corners */
                padding: 20px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);  /* Light shadow for depth */
                text-align: center;
                background-color: #fff;  /* White background for the card */
                overflow: hidden;        /* Ensure the image is clipped to the rounded corners */
                position: relative;      /* For background-image positioning */
            }

            .course-card img {
                width: 100%;             /* Ensure the image fills the container */
                height: 100px;           /* Fixed height */
                object-fit: cover;       /* Cover the space without stretching */
                border-radius: 15px;     /* Round the image corners */
                margin-bottom: 15px;     /* Space below the image */
            }

            /* Optional background image for the card */
            .course-card::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-image: url('img/your-background.jpg');  /* Replace with your background image */
                background-size: cover;
                background-position: center;
                opacity: 0.1;  /* Light opacity for subtle background image */
                border-radius: 15px;  /* Ensure the background image has rounded corners */
                z-index: -1;           /* Place the background behind the content */
            }
            .btn-light-custom {
                background-color: #28a745; /* Lighter green (adjust as needed) */
                border: 1px solid #28a745; /* Matching border color */
                color: white;
            }

            .btn-light-custom:hover {
                background-color: #6fda6a; /* A softer hover color */
                border-color: #6fda6a; /* Border color on hover */
                color: white;
            }
            
            .nav-item {
                margin-left: 20px; /* Adjust left spacing */
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
                    width: 50px; /* Smaller logo on mobile */
                }
                .content {
                    margin-top: 120px; /* Extra space for small screens */
                }
            }
        </style>
    </head>
    <body>

        <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <!--  First Line: Contact & Social Icons -->
            <div class="top-bar">
                <div class="container d-flex justify-content-between">
                    <div>
                        <i class="fas fa-phone"></i> <a href="tel:+1234567890">+123-456-7890</a>
                        <i class="fas fa-envelope"></i> <a href="mailto:info@example.com">info@example.com</a>
                    </div>
                    <div>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!--  Second Line: Logo, Institute Name & Navbar -->
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand d-flex align-items-center" href="#">
                        <img src="<?= base_url('public/assets/img/logo.jpg'); ?>" alt="Logo" class="me-2"> 
                        Institute Name
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">About</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Courses</a></li>
                            <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                            <li class="nav-item"><a href="#" class="btn btn-light-custom">APPLY NOW</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <div class="container content">
            <!-- Image Section with Welcome Message -->
            <div class="welcome-message-container position-relative" style="background-image: url('<?= base_url('public/assets/img/ima1.jpg'); ?>'); background-size: cover; background-position: center; height: 400px;">
                <div class="welcome-message text-white py-4 px-5 position-absolute top-50 start-10 translate-middle-y" style="background-color: rgba(0, 0, 0, 0.7); max-width: 300px; left: 30px; width: auto;">
                    <h2>Welcome</h2>
                    <p>We provide quality education and empower students for a brighter future. Join us to start your journey today.</p>
                    <a href="#" class="btn btn-light-custom">Learn More</a>
                </div>
            </div>




            <!--  Popular Courses Section -->
            <div class="popular-courses py-5">
                <div class="container">
                    <h2 class="text-center mb-5">Popular Courses</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 1">
                                <h3>Course Title 1</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 2">
                                <h3>Course Title 2</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 3">
                                <h3>Course Title 3</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <h2 class="text-center mb-5">Our Activities</h2>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 1">
                                <h3>Course Title 1</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 2">
                                <h3>Course Title 2</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="course-card">
                                <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Course 3">
                                <h3>Course Title 3</h3>
                                <p>Short description of the course content.</p>
                                <a href="#" class="btn btn-light-custom">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <footer class="footer bg-dark text-white py-4 mt-5">
            <div class="container">
                <div class="row">
                    <!-- Logo and Institute Name -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <a class="navbar-brand d-flex align-items-center text-white" href="#">
                            <img src="<?= base_url('public/assets/img/ima1.jpg'); ?>" alt="Logo" class="me-2" style="width: 50px; height: auto;">
                            Institute Name
                        </a>
                    </div>
                    <!-- Footer Navigation Links -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <ul class="navbar-nav justify-content-center">
                            <li class="nav-item"><a class="nav-link text-white" href="#">Home</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="#">About</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="#">Courses</a></li>
                            <li class="nav-item"><a class="nav-link text-white" href="#">Contact</a></li>
                        </ul>
                    </div>
                    <!-- Footer Contact Info & Apply Now Button -->
                    <div class="col-md-4">
                        <ul class="list-unstyled">
                            <li><a href="tel:+1234567890" class="text-white"><i class="fas fa-phone"></i> +123-456-7890</a></li>
                            <li><a href="mailto:info@example.com" class="text-white"><i class="fas fa-envelope"></i> info@example.com</a></li>
                            <li><a href="#" class="btn btn-light-custom mt-3">Apply Now</a></li>
                        </ul>
                    </div>
                </div>
                <hr class="bg-white">
                <div class="text-center">
                    <p>&copy; 2025 Institute Name. All rights reserved.</p>
                </div>
            </div>
        </footer>


    </body>
</html>