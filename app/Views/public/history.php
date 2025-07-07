






<!-- chinmoy is testing new code -->



<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("layouts/base-structure/header"); ?>
        </div>
        <div class="container content">







<!--start-->
<section class="history-section py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Our History</h2>
            <p class="text-muted">A journey of excellence and growth.</p>
        </div>

        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-year">1990</div>
                <div class="timeline-content">
                    <h3>School Founded</h3>
                    <p>Established to provide quality education and a bright future.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2005</div>
                <div class="timeline-content">
                    <h3>Campus Expansion</h3>
                    <p>New buildings and programs introduced for better learning.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2015</div>
                <div class="timeline-content">
                    <h3>National Recognition</h3>
                    <p>Ranked among the top educational institutions.</p>
                </div>
            </div>

            <div class="timeline-item">
                <div class="timeline-year">2025</div>
                <div class="timeline-content">
                    <h3>Future Vision</h3>
                    <p>Continuing innovation in education with technology.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .history-section {
        background-color: #f9f9f9;
    }

    .timeline {
        position: relative;
        padding: 0;
        max-width: 900px;
        margin: auto;
    }

    .timeline-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .timeline-year {
        font-size: 1.2rem;
        font-weight: bold;
        color: #007bff;
        min-width: 80px;
        text-align: center;
        padding: 10px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .timeline-content {
        background: white;
        padding: 12px 15px;
        border-left: 3px solid #007bff;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        flex-grow: 1;
        margin-left: 15px;
    }

    .timeline-content h3 {
        font-size: 1rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .timeline-content p {
        font-size: 0.9rem;
        margin: 0;
        color: #555;
    }

    @media (max-width: 768px) {
        .timeline {
            max-width: 100%;
        }

        .timeline-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .timeline-year {
            width: auto;
            margin-bottom: 5px;
        }

        .timeline-content {
            margin-left: 0;
            width: 100%;
        }
    }
</style>
<!--end-->













        </div>


        <?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>
  
