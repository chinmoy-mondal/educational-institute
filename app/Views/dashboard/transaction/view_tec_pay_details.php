<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
.decimal-align {
    text-align: right;
    font-family: 'Consolas', 'Courier New', monospace;
}

.info-card {
    border-left: 4px solid #198754;
}

.teacher-name {
    font-size: 22px;
    font-weight: 600;
}

.summary-box {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 15px;
}
</style>

<div class="container-fluid">

    <!-- PAGE TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3 class="mb-1">Teacher Payment Details</h3>
            <p class="text-muted mb-0">
                Complete payment history of teacher
            </p>
        </div>

        <div>
            <a href="<?= base_url('admin/tec_pay') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <!-- TEACHER INFO -->
    <div class="card info-card mb-4">
        <div class="card-body">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <div class="teacher-name">
                        <?= esc($teacher['name'] ?? 'Teacher') ?>
                    </div>

                    <hr>

                    <div class="row">

                        <?php if (!empty($teacher['email'])): ?>
                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong>
                            <?= esc($teacher['email']) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($teacher['phone'])): ?>
                        <div class="col-md-6 mb-2">
                            <strong>Phone:</strong>
                            <?= esc($teacher['phone']) ?>
                        </div>
                        <?php endif; ?>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="summary-box text-center">

                        <h6 class="text-muted mb-2">
                            Total Paid Amount
                        </h6>

                        <h2 class="text-success fw-bold">
                            ৳ <?= number_format($total_paid ?? 0, 2) ?>
                        </h2>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- PAYMENT TABLE -->
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0">
                Payment History
            </h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped table-hover table-sm">

                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Amount Paid</th>
                        <th>Date & Time</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($payments)): ?>

                    <?php $i = 1; ?>

                    <?php foreach ($payments as $pay): ?>

                    <tr class="text-center">

                        <td>
                            <?= $i++ ?>
                        </td>

                        <td class="decimal-align">
                            <?= number_format($pay['amount_paid'] ?? 0, 2) ?> ৳
                        </td>

                        <td>
                            <?= date('d M Y h:i A', strtotime($pay['created_at'])) ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                    <?php else: ?>

                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No payment history found
                        </td>
                    </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<?= $this->endSection() ?>