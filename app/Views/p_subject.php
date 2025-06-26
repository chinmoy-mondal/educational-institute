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
        // Step 1: Separate class 9 general and 9 vocational
        $subjectsByClass = [];

        foreach ($subjects as $subject) {
            if (trim($subject['class']) === '9 Vocational') {
                $subjectsByClass['9 Vocational'][] = $subject;
            } elseif (trim($subject['class']) === '9') {
                $subjectsByClass['9'][] = $subject;
            } else {
                $subjectsByClass[$subject['class']][] = $subject;
            }
        }

        // Optional: sort by class number (6,7,8,9,9 Vocational)
        uksort($subjectsByClass, function($a, $b) {
            // push '9 Vocational' to the end
            if ($a === '9 Vocational') return 1;
            if ($b === '9 Vocational') return -1;
            return $a <=> $b;
        });
        ?>

        <?php foreach ($subjectsByClass as $class => $classSubjects): ?>
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
