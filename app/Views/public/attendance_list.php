<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <h2 class="mb-4">Student Attendance List</h2>

    <!-- Filter Form -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="class" class="form-label">Class</label>
            <select name="class" id="class" class="form-select">
                <option value="">All Classes</option>
                <?php foreach($classes as $c): ?>
                    <option value="<?= esc($c['class']) ?>" <?= ($selectedClass == $c['class']) ? 'selected' : '' ?>>
                        <?= esc($c['class']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label for="section" class="form-label">Section</label>
            <select name="section" id="section" class="form-select">
                <option value="">All Sections</option>
                <?php foreach($sections as $s): ?>
                    <option value="<?= esc($s['section']) ?>" <?= ($selectedSection == $s['section']) ? 'selected' : '' ?>>
                        <?= esc($s['section']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="<?= base_url('attendance') ?>" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <!-- Student Table -->
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