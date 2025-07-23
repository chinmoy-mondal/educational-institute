<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="mb-4"><?= esc($title ?? 'Result Check') ?></h1>

    <div class="card">
        <div class="card-header">
            <strong>Subject:</strong> <?= esc($subject['subject'] ?? 'N/A') ?>
        </div>
        <div class="card-body">
            <h5>Assigned Teachers</h5>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li><?= esc($user['name']) ?> (<?= esc($user['email']) ?>)</li>
                <?php endforeach ?>
            </ul>

            <hr>

            <h5>Students Assigned to this Subject</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Roll</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Section</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?= esc($student['roll']) ?></td>
                            <td><?= esc($student['student_name']) ?></td>
                            <td><?= esc($student['class']) ?></td>
                            <td><?= esc($student['section']) ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
