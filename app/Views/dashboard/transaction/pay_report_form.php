<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-1">Payment Analytics</h3>
            <small class="text-muted">Filter and analyze financial transactions</small>
        </div>
    </div>

    <!-- ================= FILTER CARD ================= -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">
                <i class="fas fa-filter me-1"></i> Report Filter
            </h6>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('admin/pay_report') ?>">

                <div class="row g-3">

                    <!-- Start -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>"
                            class="form-control shadow-sm" required>
                    </div>

                    <!-- End -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>"
                            class="form-control shadow-sm" required>
                    </div>

                    <!-- Type -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Type</label>
                        <select name="type" class="form-select shadow-sm">
                            <option value="all">All</option>
                            <option value="student">Student Payment</option>
                            <option value="teacher">Teacher Payment</option>
                            <option value="salary">Salary</option>
                            <option value="cost">Expense</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-success w-100 shadow-sm">
                            <i class="fas fa-search me-1"></i> Generate Report
                        </button>
                    </div>

                </div>

            </form>

        </div>
    </div>

    <!-- ================= REPORT ================= -->
    <?php if (!empty($report)): ?>

        <!-- 🔥 SUMMARY BAR -->
        <div class="row g-3 mb-4">

            <?php
            $total = 0;
            foreach ($report as $r) {
                $total += ($r['amount'] - ($r['discount'] ?? 0));
            }
            ?>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted">Total Records</small>
                        <h4 class="fw-bold mb-0"><?= count($report) ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted">Total Amount</small>
                        <h4 class="fw-bold mb-0">৳ <?= number_format($total, 2) ?></h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                    <div class="card-body">
                        <small class="text-muted">Report Status</small>
                        <h4 class="fw-bold mb-0 text-success">Active</h4>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TABLE CARD ================= -->
        <div class="card shadow-sm border-0">

            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Transaction Report</h6>

                <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1" class="btn btn-light btn-sm">
                    <i class="fas fa-download me-1"></i> Export
                </a>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Sender</th>
                                <th>Receiver</th>
                                <th>Amount</th>
                                <th>Description</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php
                            $typeLabels = [
                                'student' => 'Student Payment',
                                'teacher' => 'Teacher Payment',
                                'salary'  => 'Salary',
                                'cost'    => 'Expense'
                            ];
                            ?>

                            <?php foreach ($report as $key => $row): ?>
                                <tr>
                                    <td class="text-center"><?= $key + 1 ?></td>

                                    <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                                    <td>
                                        <span class="badge bg-primary">
                                            <?= $typeLabels[$row['activity']] ?? ucfirst($row['activity']) ?>
                                        </span>
                                    </td>

                                    <td><?= $row['sender_name'] ?? '-' ?></td>
                                    <td><?= $row['receiver_name'] ?? '-' ?></td>

                                    <td class="fw-bold text-success">
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

        <div class="alert alert-warning shadow-sm">
            No transactions found for selected filters.
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>