<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- Page Heading -->
    <h3 class="fw-bold text-primary mb-0">💳 Student Payments</h3>
    <small class="text-muted fst-italic">Take a quick look at student payment status</small>

    <!-- ✅ Search Form: place here, above the table -->
    <div class="row mb-3">
        <div class="col">
            <form method="get" action="<?= base_url('admin/std_pay') ?>" class="row g-2 align-items-center">

                <!-- Single text input for roll, ID, or name -->
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Roll, ID, or Name" value="<?= esc($this->request->getGet('search')) ?>">
                </div>

                <!-- Select Inputs -->
                <div class="col-md-2">
                    <select name="class" class="form-select">
                        <option value="">Select Class</option>
                        <?php foreach($classes as $c): ?>
                            <option value="<?= esc($c['class']) ?>" <?= ($this->request->getGet('class') == $c['class']) ? 'selected' : '' ?>>
                                <?= esc($c['class']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="section" class="form-select">
                        <option value="">Select Section</option>
                        <?php foreach($sections as $s): ?>
                            <option value="<?= esc($s['section']) ?>" <?= ($this->request->getGet('section') == $s['section']) ? 'selected' : '' ?>>
                                <?= esc($s['section']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>

            </form>
        </div>
    </div>

    <!-- Student Table -->
    <div class="card mt-3 shadow-sm">
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
                    <?php if(!empty($students)): ?>
                        <?php $i=1; foreach($students as $s): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($s['roll']) ?></td>
                                <td><?= esc($s['id']) ?></td>
                                <td><?= esc($s['student_name']) ?></td>
                                <td><?= esc($s['class']) ?></td>
                                <td><?= esc($s['section']) ?></td>
                                <td>
                                    <?php if($s['paid'] ?? 0): ?>
                                        <span class="badge bg-success">Paid</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>৳ <?= number_format($s['amount_paid'] ?? 0,2) ?></td>
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