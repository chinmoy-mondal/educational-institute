<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Payment Report</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Payment Details</h5>
            <button class="btn btn-light btn-sm" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle text-sm" id="paymentReportTable">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Month</th>
                        <th class="text-end">Total Pay</th>
                        <th class="text-end">Total Discount</th>
                        <th class="text-end">Net Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($report as $row): ?>
                        <tr>
                            <td><?= esc($row['sender_name']) ?></td>
                            <td><?= esc($row['receiver_name']) ?></td>
                            <td><?= esc($row['month']) ?></td>
                            <td class="text-end"><?= number_format($row['total_pay'], 2) ?></td>
                            <td class="text-end"><?= number_format($row['total_discount'], 2) ?></td>
                            <td class="text-end <?= ($row['net_amount'] < 0) ? 'text-danger' : 'text-success' ?>">
                                <?= number_format($row['net_amount'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

                <!-- <?php if (!empty($report)): ?>
                <tfoot class="table-secondary fw-bold text-end">
                    <?php
                            $totalPay = array_sum(array_column($report, 'total_pay'));
                            $totalDiscount = array_sum(array_column($report, 'total_discount'));
                            $totalNet = array_sum(array_column($report, 'net_amount'));
                    ?>
                    <tr>
                        <td colspan="3" class="text-center">TOTAL</td>
                        <td><?= number_format($totalPay, 2) ?></td>
                        <td><?= number_format($totalDiscount, 2) ?></td>
                        <td class="<?= ($totalNet < 0) ? 'text-danger' : 'text-success' ?>">
                            <?= number_format($totalNet, 2) ?></td>
                    </tr>
                </tfoot>
                <?php endif; ?> -->
            </table>
        </div>
    </div>
</div>

<!-- Print-friendly styles -->
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #paymentReportTable,
        #paymentReportTable * {
            visibility: visible;
        }

        #paymentReportTable {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
</style>

<?= $this->endSection() ?>