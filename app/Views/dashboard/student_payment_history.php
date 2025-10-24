<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4><i class="fas fa-receipt"></i> Student Payment History</h4>
                <a href="<?= base_url('admin/std_pay') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Student Info -->
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="mb-3">Student Information</h5>
                    <table class="table table-bordered table-sm mb-0">
                        <tr>
                            <th width="150">Student ID</th>
                            <td><?= esc($student['id'] ?? 'N/A') ?></td>
                            <th width="150">Name</th>
                            <td><?= esc($student['name'] ?? 'N/A') ?></td>
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
                            <th>Total Fees</th>
                            <td><strong><?= number_format($totalFees ?? 0, 2) ?> ৳</strong></td>
                        </tr>
                        <tr>
                            <th>Total Paid</th>
                            <td><strong class="text-success"><?= number_format($totalPaid ?? 0, 2) ?> ৳</strong></td>
                            <th>Due Amount</th>
                            <td><strong class="text-danger"><?= number_format(($totalFees ?? 0) - ($totalPaid ?? 0), 2) ?> ৳</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Payment History -->
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-history"></i> Payment Transactions</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Transaction ID</th>
                                <th>Sender Name</th>
                                <th>Receiver Name</th>
                                <th>Amount (৳)</th>
                                <th>Purpose</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th width="150">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($transactions)): ?>
                                <?php $i = 1;
                                foreach ($transactions as $t): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($t['transaction_id']) ?></td>
                                        <td><?= esc($t['sender_name']) ?></td>
                                        <td><?= esc($t['receiver_name']) ?></td>
                                        <td><?= number_format($t['amount'], 2) ?></td>
                                        <td><?= esc($t['purpose']) ?></td>
                                        <td><?= esc($t['description']) ?></td>
                                        <td>
                                            <?php if ($t['status'] === 'approved'): ?>
                                                <span class="badge bg-success">Approved</span>
                                            <?php elseif ($t['status'] === 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Rejected</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= date('d M, Y h:i A', strtotime($t['created_at'])) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">No transaction history found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </section>
</div>

<?= $this->endSection() ?>