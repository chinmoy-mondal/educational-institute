
<!-- Bootstrap Carousel -->
<div id="indicatorCarousel" class="carousel slide" data-bs-ride="carousel">
    <!-- Indicators -->
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#indicatorCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#indicatorCarousel" data-bs-slide-to="1"></button>
    </div>

    <!-- Carousel Items -->
    <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="slider-container" style="background-image: url('<?= base_url('public/assets/img/ima1.jpg'); ?>');">
                <div class="carousel-caption custom-caption">
                    <h2>Welcome</h2>
                    <p>We provide quality education and empower students for a brighter future.</p>
                    <a href="#" class="btn btn-light btn-custom">Learn More</a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="slider-container" style="background-image: url('<?= base_url('public/assets/img/ima2.jpg'); ?>');">
                <div class="carousel-caption custom-caption">
                    <h2>Shape Your Future</h2>
                    <p>Explore diverse learning opportunities and build a strong foundation for success.</p>
                    <a href="#" class="btn btn-light btn-custom">Discover More</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Controls -->
    <!--<button class="carousel-control-prev" type="button" data-bs-target="#indicatorCarousel" data-bs-slide="prev">-->
    <!--    <span class="carousel-control-prev-icon"></span>-->
    <!--</button>-->
    <!--<button class="carousel-control-next" type="button" data-bs-target="#indicatorCarousel" data-bs-slide="next">-->
    <!--    <span class="carousel-control-next-icon"></span>-->
    <!--</button>-->
</div>

<!-- Styles -->
<style>
    .slider-container {
        height: 400px; /* Adjust height as needed */
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .custom-caption {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 20px;
        border-radius: 10px;
        display: inline-block;
        text-align: left;
        max-width: 350px;
        position: absolute;
        top: 50%;
        left: 30px;
        transform: translateY(-50%);
    }

    .custom-caption h2,
    .custom-caption p {
        margin-bottom: 10px;
    }

    .btn-custom {
        background-color: rgba(255, 255, 255, 0.8);
        color: #000;
        font-weight: bold;
    }

    .btn-custom:hover {
        background-color: white;
    }
</style>