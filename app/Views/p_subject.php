<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<div class="container content">
<section class="py-5">
    <div class="container">
        <h3 class="text-center mb-4 fw-bold">Subjects Offered (Classes 6 to 9 & Vocational)</h3>

        <?php
        // Separate Class 9 (general), Class 9 Vocational, and others
        $class9 = [];
        $class9voc = [];
        $otherClasses = [];

        foreach ($subjects as $subject) {
            $class = trim($subject['class']);
            if ($class === '9') {
                $class9[] = $subject;
            } elseif ($class === '9 Vocational') {
                $class9voc[] = $subject;
            } else {
                $otherClasses[$class][] = $subject;
            }
        }

        ksort($otherClasses); // Sort other classes like 6, 7, 8
        ?>

        <!-- Show other classes -->
        <?php foreach ($otherClasses as $class => $classSubjects): ?>
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

        <!-- Class 9 Table -->
        <?php if (!empty($class9)): ?>
            <h4 class="mb-3 mt-5 text-success fw-bold">Class 9 (General)</h4>
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
                        <?php foreach ($class9 as $subject): ?>
                            <tr>
                                <td><?= esc($subject['class']) ?></td>
                                <td><?= esc($subject['section']) ?></td>
                                <td><?= esc($subject['subject']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <!-- Class 9 Vocational Table -->
        <?php if (!empty($class9voc)): ?>
            <h4 class="mb-3 mt-5 text-danger fw-bold">Class 9 (Vocational)</h4>
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
                        <?php foreach ($class9voc as $subject): ?>
                            <tr>
                                <td><?= esc($subject['class']) ?></td>
                                <td><?= esc($subject['section']) ?></td>
                                <td><?= esc($subject['subject']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</section>
</div>

<?= $this->include("structure/footer"); ?>
<?= $this->endSection(); ?>
