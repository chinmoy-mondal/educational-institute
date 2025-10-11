<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-user-check me-2"></i> Attendance</h5>
                    <!-- Show selected Class and Date -->
                    <div class="text-white fw-bold">
                        Class: <?= $selectedClass ?: 'All' ?> &nbsp; | &nbsp; Date: <?= $selectedDate ?>
                    </div>
                </div>
                <div class="card-body">

                    <!-- Filter Form -->
                    <form method="post" action="<?= site_url('admin/attendance/calendar') ?>" class="d-flex align-items-center gap-2 mb-3 flex-wrap">

                        <!-- Class Selector -->
                        <div class="d-flex flex-column">
                            <label for="class" class="form-label fw-bold mb-0">Class</label>
                            <select name="class" id="class" class="form-select form-select-sm">
                                <option value="">Select Class</option>
                                <?php for ($c = 6; $c <= 10; $c++): ?>
                                    <option value="<?= $c ?>" <?= $selectedClass == $c ? 'selected' : '' ?>>Class <?= $c ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Date Picker -->
                        <div class="d-flex flex-column">
                            <label for="date" class="form-label fw-bold mb-0">Date</label>
                            <input type="date" name="date" id="date" value="<?= $selectedDate ?>" class="form-control form-control-sm">
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex flex-column align-items-start">
                            <label class="form-label mb-0">&nbsp;</label> <!-- empty label to align with inputs -->
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-calendar-alt me-1"></i> Show
                            </button>
                        </div>

                    </form>

                    <!-- Attendance Table -->
                    <form method="post" action="<?= site_url('admin/attendance/save') ?>">
                        <input type="hidden" name="date" value="<?= $selectedDate ?>">
                        <input type="hidden" name="class" value="<?= $selectedClass ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered table-sm align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>Roll</th>
                                        <th>Name</th>
                                        <th>Attendance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $s):
                                        $remark = $attendanceMap[$s['id']] ?? '';
                                    ?>
                                        <tr>
                                            <td><?= esc($s['roll']) ?></td>
                                            <td><?= esc($s['student_name']) ?></td>
                                            <td>
                                                <select name="attendance[<?= $s['id'] ?>]" class="form-select form-select-sm">
                                                    <option value="">--</option>
                                                    <option value="P" <?= $remark == 'P' ? 'selected' : '' ?>>P</option>
                                                    <option value="A" <?= $remark == 'A' ? 'selected' : '' ?>>A</option>
                                                    <option value="L" <?= $remark == 'L' ? 'selected' : '' ?>>L</option>
                                                </select>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Save Attendance</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>