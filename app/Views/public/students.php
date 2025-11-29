<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="container py-5">

    <h2 class="mb-4 fw-bold">Student List</h2>

    <!-- ───────────── search / filter form ───────────── -->
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-3">
            <input type="text" name="name" class="form-control"
                value="<?= esc($name) ?>" placeholder="Search by name">
        </div>
        <div class="col-md-2">
            <input type="text" name="roll" class="form-control"
                value="<?= esc($roll) ?>" placeholder="Roll">
        </div>
        <div class="col-md-2">
            <select name="class" class="form-select">
                <option value="">-- Class --</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= esc($c['class']) ?>" <?= $class === $c['class'] ? 'selected' : '' ?>>
                        <?= esc($c['class']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="section" class="form-select">
                <option value="">-- Section --</option>
                <?php foreach ($sections as $s): ?>
                    <option value="<?= esc($s['section']) ?>" <?= $section === $s['section'] ? 'selected' : '' ?>>
                        <?= esc($s['section']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- ───────────── pager links ───────────── -->
    <?= $pager->links() ?>

    <!-- ───────────── table ───────────── -->
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Roll</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Gender</th>
                    <th>Religion</th>
                    <th>Blood&nbsp;Group</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($students): ?>
                    <?php foreach ($students as $st): ?>
                        <tr>
                            <td><?= esc($st['roll']) ?></td>
                            <td><?= esc($st['student_name']) ?></td>
                            <td><?= esc($st['class']) ?></td>
                            <td><?= esc($st['section']) ?></td>
                            <td><?= esc($st['gender']) ?></td>
                            <td><?= esc($st['religion']) ?></td>
                            <td><?= esc($st['blood_group']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">No students found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>



</div>
<?= $this->endSection() ?>