
            <!--  First Line: Contact & Social Icons -->
            <div class="top-bar">
                <div class="container d-flex justify-content-between">
                    <div>
                        <i class="fas fa-phone"></i> <a href="tel:+8801309115832">+8801309115832</a>
                        <i class="fas fa-envelope"></i> <a href="mailto:info@example.com">s115832mul@gmail.com</a>
                    </div>
                    <div>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!--  Second Line: Logo, Institute Name & Navbar -->
            <nav class="navbar navbar-expand-lg navbar-dark  bg-dark">
                <div class="container">
                    <a class="navbar-brand" href="<?= base_url(''); ?>"><img src="<?= base_url('public/assets/img/logo.jpg'); ?>">Mulgram Secondary School</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
            
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" href="<?= base_url(''); ?>">Home</a>
                            </li>
            
                            <!-- About Us -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">About</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= base_url('home/welcome'); ?>">Welcome Message</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('home/history'); ?>">Our History</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('home/mission'); ?>">Mission & Vision</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('home/staff'); ?>">Faculty & Staff</a></li>
                                </ul>
                            </li>
            
                            <!-- Academics -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Academics</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Curriculum</a></li>
                                    <li><a class="dropdown-item" href="#">Subjects</a></li>
                                    <li><a class="dropdown-item" href="#">Exams & Results</a></li>
                                </ul>
                            </li>
            
                            <!-- Admissions -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Admissions</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">How to Apply</a></li>
                                    <li><a class="dropdown-item" href="#">Fee Structure</a></li>
                                    <li><a class="dropdown-item" href="#">Scholarships</a></li>
                                </ul>
                            </li>
            
                            <!-- Students -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Students</a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Student Portal</a></li>
                                    <li><a class="dropdown-item" href="#">Clubs & Activities</a></li>
                                    <li><a class="dropdown-item" href="#">Library</a></li>
                                </ul>
                            </li>
            
                            <!-- Events -->
                            <li class="nav-item">
                                <a class="nav-link" href="#">Events</a>
                            </li>
            
                            <!-- Contact -->
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                            </li>
                        </ul>
            
                        <!-- Account Button -->
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle btn btn-light" href="#" role="button" data-bs-toggle="dropdown">
                                    Account
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="<?= base_url('register'); ?>">Register</a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('login'); ?>">Login</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>