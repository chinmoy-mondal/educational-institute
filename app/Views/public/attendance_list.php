<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="mb-4">Student Attendance List</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Student Name</th>
                <th>Roll</th>
                <th>Class</th>
                <th>Section</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($students)): ?>
                <?php $i = 1; foreach($students as $student): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($student['student_name']) ?></td>
                        <td><?= esc($student['roll']) ?></td>
                        <td><?= esc($student['class']) ?></td>
                        <td><?= esc($student['section']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No students found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>