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
        // Separate 9 and 9 Vocational
        $groupedSubjects = [];

        foreach ($subjects as $subject) {
            if (trim($subject['class']) === '9 Vocational') {
                $groupedSubjects['9 Vocational'][] = $subject;
            } else {
                $groupedSubjects[$subject['class']][] = $subject;
            }
        }

        ksort($groupedSubjects); // Optional: Sort by class name
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
</div>

<?= $this->include("structure/footer"); ?>
<?= $this->endSection(); ?>
