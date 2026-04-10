<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">💰 Financial Overview</h2>
            <small class="text-muted">Earnings, expenses and analytics dashboard</small>
        </div>
    </div>

    <?php if (($account_status ?? 0) > 1): ?>

        <!-- ================= KPI CARDS ================= -->
        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <h6>Total Earn</h6>
                        <h3>৳ <?= number_format($totalEarn ?? 0, 2) ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-danger text-white shadow-sm">
                    <div class="card-body">
                        <h6>Total Cost</h6>
                        <h3>৳ <?= number_format($totalCost ?? 0, 2) ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <h6>Net Balance</h6>
                        <h3>৳ <?= number_format(($totalEarn ?? 0) - ($totalCost ?? 0), 2) ?></h3>
                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

    <!-- ================= FILTER CARD ================= -->
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">
            <strong>Report Filter</strong>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('admin/pay_report') ?>">

                <div class="row g-3">

                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control"
                            value="<?= $_GET['start_date'] ?? '' ?>" required>
                    </div>

                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" value="<?= $_GET['end_date'] ?? '' ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="all">All</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="salary">Salary</option>
                            <option value="cost">Cost</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button class="btn btn-success w-100">
                            Generate Report
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- ================= REPORT TABLE ================= -->
    <?php if (!empty($report)): ?>

        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <span>Transaction Report</span>
                <span><?= count($report) ?> records</span>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th class="text-end">Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $typeLabels = [
                                'student' => 'Student',
                                'teacher' => 'Teacher',
                                'salary'  => 'Salary',
                                'cost'    => 'Expense'
                            ];

                            $total = 0;
                            ?>

                            <?php foreach ($report as $i => $row): ?>

                                <?php $total += ($row['amount'] - ($row['discount'] ?? 0)); ?>

                                <tr>
                                    <td><?= $i + 1 ?></td>

                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= $typeLabels[$row['activity']] ?? 'Other' ?>
                                        </span>
                                    </td>

                                    <td><?= esc($row['sender_name']) ?></td>
                                    <td><?= esc($row['receiver_name']) ?></td>

                                    <td class="text-end fw-bold text-success">
                                        ৳ <?= number_format($row['amount'] - ($row['discount'] ?? 0), 2) ?>
                                    </td>

                                    <td><?= esc($row['description']) ?></td>
                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Total</th>
                                <th colspan="2">৳ <?= number_format($total, 2) ?></th>
                            </tr>
                        </tfoot>

                    </table>

                </div>

            </div>
        </div>

    <?php elseif (isset($_GET['start_date'])): ?>

        <div class="alert alert-warning mt-3">
            No data found for selected range.
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>