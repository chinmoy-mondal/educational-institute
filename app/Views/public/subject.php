<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header'); ?>
</div>

<div class="container content">
<section class="py-5">
    <div class="container">
        <h3 class="text-center mb-4 fw-bold">
            Subjects Offered (Classes 6 to 9 & Vocational)
        </h3>

<?php
// Group by class + section pair
$grouped = [];

foreach ($subjects as $row) {
    $class = trim($row['class']);
    $section = trim($row['section']);
    $key = $class . '|' . $section;

    $grouped[$key][] = $row;
}

// Sort by class and section
ksort($grouped);print_r(array_keys($grouped));

function renderTable($class, $section, $rows) {
    ?>
    <h4 class="mb-3 mt-5 text-primary fw-bold">
        Class <?= esc($class) ?> <?= $section ? "(Section " . esc($section) . ")" : "" ?>
    </h4>
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
                <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= esc($row['class']) ?></td>
                    <td><?= esc($row['section']) ?></td>
                    <td><?= esc($row['subject']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}
?>

<?php
// Render each (class + section) table
foreach ($grouped as $key => $rows) {
    [$class, $section] = explode('|', $key);
    renderTable($class, $section, $rows);
}
?>

    </div>
</section>
</div>

<?= $this->include('layouts/base-structure/footer'); ?>
<?= $this->endSection() ?>
