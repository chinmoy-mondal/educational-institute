<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <h3 class="fw-bold text-danger mb-4">💰 Student Due List</h3>

    <!-- Month Selector -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="get">
                <div class="row">
                    <div class="col-md-4">
                        <label>Select Month</label>
                        <select name="month" class="form-control" onchange="this.form.submit()">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= (($_GET['month'] ?? date('n')) == $m) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $selectedMonth = $_GET['month'] ?? date('n');
    ?>

    <!-- Student Due Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Cumulative Due</th>
                        <th>Current Month</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($students)): ?>
                    <?php foreach ($students as $key => $std):

                            $section = trim($std['section']);

                            $cumulative = $all_month_fees[$selectedMonth][$section]['cumulative'] ?? 0;
                            $current    = $all_month_fees[$selectedMonth][$section]['current'] ?? 0;
                        ?>

                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= esc($std['student_name']) ?></td>
                        <td><?= esc($std['class']) ?></td>
                        <td><?= esc($section) ?></td>
                        <td class="text-danger fw-bold">
                            ৳ <?= number_format($cumulative, 2) ?>
                        </td>
                        <td class="text-primary fw-bold">
                            ৳ <?= number_format($current, 2) ?>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-danger">
                            No students found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>