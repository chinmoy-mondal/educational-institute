<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Header -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<div class="container content">

<!-- Head Sir Message -->
<section class="head-sir-message py-5 position-relative">
    <div class="overlay"></div>
    <div class="container position-relative text-white text-center">
        <div class="row align-items-center">
            <div class="col-lg-4 text-center">
                <div class="sir-image">
                    <img src="<?= base_url('public/assets/img/headsir.jpg'); ?>" alt="Head Sir" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-8 text-lg-start">
                <h2 class="fw-bold">Message from the Head Sir</h2>
                <p class="fst-italic">"Education is the most powerful weapon which you can use to change the world." – Nelson Mandela</p>
                <p>
                    It is my great pleasure to welcome you to our school...
                </p>
                <h5 class="fw-bold mt-3">- [Head Sir's Name]</h5>
                <p class="fst-italic">Head of School</p>
            </div>
        </div>
    </div>
</section>

<!-- Subject Table Section -->
<section class="py-5">
    <div class="container">
        <h3 class="text-center mb-4 fw-bold">Subjects Offered (Classes 6 to 9 & Vocational)</h3>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Subject</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($subjects as $subject): ?>
                        <tr>
                            <td><?= esc($subject['class']) ?></td>
                            <td><?= esc($subject['section']) ?></td>
                            <td><?= esc($subject['subject']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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

    .sir-image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        border: 5px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
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

</div>

<?= $this->include("structure/footer"); ?>
<?= $this->endSection(); ?>
