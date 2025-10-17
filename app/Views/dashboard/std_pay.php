<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- Page Heading -->
    <h3 class="fw-bold text-primary mb-0">💳 Student Payments</h3>
    <small class="text-muted fst-italic">Take a quick look at student payment status</small>

    <!-- Search Card -->
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <form method="get" action="<?= base_url('admin/std_pay') ?>" class="row g-2 align-items-center">

                <!-- Roll / ID / Name Input -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Roll, ID, or Name" value="<?= esc($search ?? '') ?>">
                    </div>
                </div>

                <!-- Class Select -->
                <div class="col-md-2">
                    <select name="class" class="form-select">
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $c): ?>
                            <option value="<?= esc($c['class']) ?>" <?= ($selectedClass ?? '') == $c['class'] ? 'selected' : '' ?>>
                                <?= esc($c['class']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Section Select -->
                <div class="col-md-2">
                    <select name="section" class="form-select">
                        <option value="">Select Section</option>
                        <?php foreach ($sections as $s): ?>
                            <option value="<?= esc($s['section']) ?>" <?= ($selectedSection ?? '') == $s['section'] ? 'selected' : '' ?>>
                                <?= esc($s['section']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                </div>

                <!-- Reset Button -->
                <div class="col-md-2">
                    <a href="<?= base_url('admin/std_pay') ?>" class="btn btn-outline-secondary w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                </div>

            </form>
        </div>
    </div>

    <!-- ✅ Student Table -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Roll</th>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Payment Status</th>
                        <th>Amount Paid</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($students)): ?>
                        <?php $i = 1;
                        foreach ($students as $s): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($s['roll']) ?></td>
                                <td><?= esc($s['id']) ?></td>
                                <td><?= esc($s['student_name']) ?></td>
                                <td><?= esc($s['class']) ?></td>
                                <td><?= esc($s['section']) ?></td>
                                <td>
                                    <?php if ($s['paid'] ?? 0): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>৳ <?= number_format($s['amount_paid'] ?? 0, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>