<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <h3 class="fw-bold text-primary mb-0">💳 Student Payments</h3>
    <small class="text-muted fst-italic">Take a quick look at student payment status</small>

    <div class="card mt-4 shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
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
                                <td><?= esc($s['name']) ?></td>
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
                            <td colspan="6" class="text-center text-muted">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>