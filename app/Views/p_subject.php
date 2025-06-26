<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- Fixed Header -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<div class="container content">

<!-- Subject Table Section -->
<section class="py-5">
    <div class="container">
        <h3 class="text-center mb-4 fw-bold">Subjects Offered (Classes 6 to 9 & Vocational)</h3>

        <?php
        // Group subjects by class
        $groupedSubjects = [];
        foreach ($subjects as $subject) {
            $groupedSubjects[$subject['class']][] = $subject;
        }
        ?>

        <?php foreach ($groupedSubjects as $class => $classSubjects): ?>
            <h4 class="mb-3 mt-5 text-primary fw-bold">Class <?= esc($class) ?></h4>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Subject</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classSubjects as $subject): ?>
                            <tr>
                                <td><?= esc($subject['class']) ?></td>
                                <td><?= esc($subject['section']) ?></td>
                                <td><?= esc($subject['subject']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; ?>
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
