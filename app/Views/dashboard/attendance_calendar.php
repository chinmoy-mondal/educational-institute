<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-check me-2"></i> Attendance Calendar</h5>
                    <form method="post" action="<?= site_url('admin/attendance/calendar') ?>" class="d-flex align-items-center mb-0">
                        <label for="month" class="me-2 mb-0 fw-bold">Month:</label>
                        <input type="month" name="month" id="month" value="<?= esc($month) ?>" class="form-control form-control-sm me-2" style="width: 180px;">
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fas fa-calendar-alt me-1"></i> Show
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <form method="post" action="<?= site_url('admin/attendance/save') ?>">
                        <input type="hidden" name="month" value="<?= esc($month) ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th class="text-nowrap">Name / Roll</th>
                                        <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
                                            <th><?= $d ?></th>
                                        <?php endfor; ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($students as $s): ?>
                                        <tr>
                                            <td class="text-nowrap">
                                                <?= esc($s['student_name']) ?> (<?= esc($s['roll']) ?>)
                                            </td>

                                            <?php for ($d = 1; $d <= $daysInMonth; $d++):
                                                $date = sprintf('%04d-%02d-%02d', $year, $monthNum, $d);
                                                $selectedRemark = $attendanceMap[$s['id']][$date] ?? '';
                                            ?>
                                                <td class="text-center">
                                                    <select name="attendance[<?= $s['id'] ?>][<?= $date ?>]"
                                                        class="form-select form-select-sm text-center"
                                                        style="min-width: 55px;">
                                                        <option value="">--</option>
                                                        <option value="P" <?= $selectedRemark == 'P' ? 'selected' : '' ?>>P</option>
                                                        <option value="A" <?= $selectedRemark == 'A' ? 'selected' : '' ?>>A</option>
                                                        <option value="L" <?= $selectedRemark == 'L' ? 'selected' : '' ?>>L</option>
                                                    </select>
                                                </td>
                                            <?php endfor; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Save Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>