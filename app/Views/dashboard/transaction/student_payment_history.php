<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- Page Heading -->
    <h3 class="fw-bold text-primary mb-4">💰 Student Payment History</h3>



    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Student Info -->
    <div class="card shadow-sm mb-4" style="padding-left:20px; padding-right:20px;">
        <div class="card-body">
            <h5 class="mb-3">Student Information</h5>
            <table class="table table-bordered table-sm mb-0 w-100">
                <tr>
                    <th width="150">Student ID</th>
                    <td><?= esc($student['id'] ?? 'N/A') ?></td>
                    <th width="150">Name</th>
                    <td><?= esc($student['student_name'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Roll</th>
                    <td><?= esc($student['roll'] ?? 'N/A') ?></td>
                    <th>Class</th>
                    <td><?= esc($student['class'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <th>Section</th>
                    <td><?= esc($student['section'] ?? 'N/A') ?></td>
                    <th>Total Paid</th>
                    <td><strong class="text-success"><?= number_format($totalPaid ?? 0, 2) ?> ৳</strong></td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Payment History -->
    <div class="card shadow-sm" style="padding-left:20px; padding-right:20px;">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-history"></i> Payment Transactions</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle text-center w-100">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Receiver Name</th>
                        <th>Amount (৳)</th>
                        <th>Discount (৳)</th>
                        <th>Purpose</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th width="150">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($payments)): ?>
                    <?php $i = 1;
                        foreach ($payments as $p): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($p['transaction_id']) ?></td>
                        <td><?= esc($p['receiver_name']) ?></td>
                        <td><?= number_format($p['amount'], 2) ?></td>
                        <td><?= number_format($p['discount'], 2) ?></td>
                        <td><?= esc($p['purpose']) ?></td>
                        <td><?= esc($p['description']) ?></td>
                        <td>
                            <?php if ($p['status'] === 'approved'): ?>
                            <span class="badge bg-success">Approved</span>
                            <?php elseif ($p['status'] === 'pending'): ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M, Y h:i A', strtotime($p['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No transaction history found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>