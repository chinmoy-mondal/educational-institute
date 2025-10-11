<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h2 class="mb-4">Student Attendance</h2>

    <!-- Month Selection -->
    <form method="post" class="mb-3 d-flex align-items-center">
        <label for="month" class="me-2">Select Month:</label>
        <input type="month" name="month" id="month" value="<?= $month ?>" class="form-control me-2" style="width: 200px;">
        <button type="submit" class="btn btn-primary">Show</button>
    </form>

    <!-- Attendance Table -->
    <form method="post" action="<?= site_url('admin/attendance/save') ?>">
        <input type="hidden" name="month" value="<?= $month ?>">
        <table class="table table-bordered table-sm table-responsive">
            <thead class="table-light text-center">
                <tr>
                    <th>Name / Roll</th>
                    <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                        <th><?= $d ?></th>
                    <?php endfor; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?= $s['student_name'] ?> (<?= $s['roll'] ?>)</td>
                        <?php for ($d = 1; $d <= $daysInMonth; $d++): 
                            $date = sprintf('%04d-%02d-%02d', $year, $monthNum, $d);
                            $selectedRemark = $attendanceMap[$s['id']][$date] ?? '';
                        ?>
                            <td class="text-center">
                                <select name="attendance[<?= $s['id'] ?>][<?= $date ?>]" class="form-select form-select-sm">
                                    <option value="">--</option>
                                    <option value="P" <?= $selectedRemark=='P'?'selected':'' ?>>P</option>
                                    <option value="A" <?= $selectedRemark=='A'?'selected':'' ?>>A</option>
                                    <option value="L" <?= $selectedRemark=='L'?'selected':'' ?>>L</option>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-success mt-2">Submit Attendance</button>
    </form>
</div>

<?= $this->endSection() ?>