<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!--  Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>
<div class="container content">







    <!--start-->
    <section class="head-sir-message py-5 position-relative">
        <div class="overlay"></div>
        <div class="container position-relative text-white text-center">
            <div class="row align-items-center">
                <!-- Image Section -->
                <div class="col-lg-4 text-center">
                    <div class="sir-image">
                        <?php if (!empty($welcome['photo'])): ?>
                        <img src="<?= base_url('uploads/welcome/' . $welcome['photo']); ?>" alt="Head Sir"
                            class="img-fluid">
                        <?php else: ?>
                        <img src="<?= base_url('public/assets/img/headsir.jpg'); ?>" alt="Head Sir" class="img-fluid">
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Message Section -->
                <div class="col-lg-8 text-lg-start">
                    <?php if (!empty($welcome)): ?>

                    <h2 class="fw-bold"><?= esc($welcome['title']); ?></h2>

                    <p class="mt-3">
                        <?= nl2br(esc($welcome['message'])); ?>
                    </p>

                    <?php else: ?>

                    <h2 class="fw-bold">Welcome Message</h2>
                    <p>No welcome message available.</p>

                    <?php endif; ?>
                    <h5 class="fw-bold mt-3">- [Head Sir's Name]</h5>
                    <p class="fst-italic">Head of School</p>
                </div>
            </div>
        </div>
    </section>

    <style>
    .head-sir-message {
        background: url('<?= base_url("public/assets/img/head-sir-bg.jpg"); ?>') no-repeat center center/cover;
        position: relative;
        padding: 80px 0;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .head-sir-message .container {
        position: relative;
        z-index: 2;
    }

    .sir-image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        border: 5px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .head-sir-message h2,
    .head-sir-message p {
        color: white;
    }

    @media (max-width: 768px) {
        .sir-image img {
            height: 250px;
        }

        .head-sir-message h2 {
            font-size: 1.8rem;
        }

        .head-sir-message p {
            font-size: 1rem;
        }
    }
    </style>
    <!--end-->













</div>


<?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>