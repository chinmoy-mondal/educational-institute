<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">💰 Payment Analytics</h3>
            <small class="text-muted">Financial overview and report analysis</small>
        </div>
    </div>

    <!-- ================= FILTER ================= -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Report Filter</strong>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('admin/pay_report') ?>">

                <div class="row g-3">

                    <div class="col-md-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>"
                            class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>" class="form-control"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Type</label>
                        <select name="type" class="form-select">
                            <option value="all">All</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="salary">Salary</option>
                            <option value="cost">Expense</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-success w-100">
                            Generate Report
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- ================= SUMMARY (LIKE YOUR DASHBOARD) ================= -->
    <?php if (!empty($report)): ?>

        <?php
        $total = 0;
        foreach ($report as $r) {
            $total += ($r['amount'] - ($r['discount'] ?? 0));
        }
        ?>

        <div class="row g-3 mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success bg-gradient text-white">
                    <div class="card-body">
                        <h6>Total Records</h6>
                        <h3><?= count($report) ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-info bg-gradient text-white">
                    <div class="card-body">
                        <h6>Total Amount</h6>
                        <h3>৳ <?= number_format($total, 2) ?></h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary bg-gradient text-white">
                    <div class="card-body">
                        <h6>Status</h6>
                        <h3>Active</h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TABLE ================= -->
        <div class="card border-0 shadow-sm">

            <div class="card-header bg-dark text-white d-flex justify-content-between">
                <strong>Transaction Report</strong>

                <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1" class="btn btn-light btn-sm">
                    Export
                </a>
            </div>

            <!-- 🔥 IMPORTANT: scroll body -->
            <div class="card-body p-0">

                <div class="table-responsive" style="max-height: 70vh; overflow-y:auto;">

                    <table class="table table-hover table-striped mb-0 align-middle">

                        <thead class="table-light sticky-top bg-light">
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
                            ?>

                            <?php foreach ($report as $i => $row): ?>
                                <tr>
                                    <td><?= $i + 1 ?></td>

                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= $typeLabels[$row['activity']] ?? ucfirst($row['activity']) ?>
                                        </span>
                                    </td>

                                    <td><?= $row['sender_name'] ?? '-' ?></td>
                                    <td><?= $row['receiver_name'] ?? '-' ?></td>

                                    <td class="text-end fw-bold text-success">
                                        ৳ <?= number_format(($row['amount'] - ($row['discount'] ?? 0)), 2) ?>
                                    </td>

                                    <td class="text-muted">
                                        <?= $row['description'] ?? '-' ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        </tbody>

                        <tfoot class="table-light">
                            <tr>
                                <th colspan="5" class="text-end">Grand Total</th>
                                <th colspan="2">৳ <?= number_format($total, 2) ?></th>
                            </tr>
                        </tfoot>

                    </table>

                </div>

            </div>

        </div>

    <?php elseif (isset($_GET['start_date'])): ?>

        <div class="alert alert-warning mt-4">
            No transactions found.
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>