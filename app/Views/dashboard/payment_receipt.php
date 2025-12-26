<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Payment Receipt</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-success text-white">
            <strong>Receipt</strong>
        </div>
        <div class="card-body">
            <p><strong>Date:</strong> <?= esc($date) ?></p>
            <p><strong>Student:</strong> <?= esc($student['name']) ?> (ID: <?= esc($student['id']) ?>)</p>
            <p><strong>Receiver:</strong> <?= esc($receiver['name']) ?></p>

            <div class="table-responsive mb-4">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Fee Title</th>
                            <th>Month</th>
                            <th>Amount (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($fees as $f): ?>
                        <tr>
                            <td><?= $sl++ ?></td>
                            <td><?= esc($f['title']) ?></td>
                            <td><?= esc($f['month']) ?></td>
                            <td><?= number_format($f['amount'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Discount</td>
                            <td><?= number_format($discount, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Total Amount</td>
                            <td><?= number_format($total_amount, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>