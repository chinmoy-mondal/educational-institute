<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- ✅ PAGE HEADER (same as dashboard) -->
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-primary mb-0">📊 Payment Report</h3>
            <small class="text-muted">Filter and analyze transactions</small>
        </div>
    </div>

    <!-- ✅ FILTER CARD -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h6 class="mb-0">
                <i class="fas fa-filter me-1"></i> Filter Report
            </h6>
        </div>

        <div class="card-body">

            <form method="get" action="<?= base_url('admin/pay_report') ?>">

                <div class="row g-3">

                    <!-- Start Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <input type="date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <!-- Type -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Transaction Type</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            <select name="type" class="form-control">
                                <option value="all">All Transactions</option>
                                <option value="student" <?= (($_GET['type'] ?? '') == 'student') ? 'selected' : '' ?>>
                                    Student Payment</option>
                                <option value="teacher" <?= (($_GET['type'] ?? '') == 'teacher') ? 'selected' : '' ?>>
                                    Teacher Payment</option>
                                <option value="salary" <?= (($_GET['type'] ?? '') == 'salary') ? 'selected' : '' ?>>
                                    Salary</option>
                                <option value="cost" <?= (($_GET['type'] ?? '') == 'cost') ? 'selected' : '' ?>>Expense
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-search"></i> Generate
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <!-- ✅ REPORT RESULT -->
    <?php if (!empty($report)): ?>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Report Result</h6>

                <!-- Download -->
                <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1" class="btn btn-light btn-sm">
                    📥 Download
                </a>
            </div>

            <!-- 🔥 IMPORTANT: NO table-responsive (fix sidebar issue) -->
            <div class="card-body">

                <table class="table table-striped align-middle mb-0">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Amount (৳)</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $total = 0;

                        $typeLabels = [
                            'student' => 'Student Payment',
                            'teacher' => 'Teacher Payment',
                            'salary'  => 'Salary',
                            'cost'    => 'Expense'
                        ];
                        ?>

                        <?php foreach ($report as $key => $row): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                <td><?= $typeLabels[$row['activity']] ?? ucfirst($row['activity']) ?></td>
                                <td><?= $row['sender_name'] ?? '-' ?></td>
                                <td><?= $row['receiver_name'] ?? '-' ?></td>
                                <td class="fw-bold">
                                    <?= number_format(($row['amount'] - ($row['discount'] ?? 0)), 2) ?>
                                </td>
                                <td><?= $row['description'] ?? '-' ?></td>
                            </tr>

                            <?php $total += ($row['amount'] - ($row['discount'] ?? 0)); ?>
                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total</th>
                            <th colspan="2">৳ <?= number_format($total, 2) ?></th>
                        </tr>
                    </tfoot>

                </table>

            </div>
        </div>

    <?php elseif (isset($_GET['start_date'])): ?>

        <div class="alert alert-warning mt-4">
            No data found for selected filters.
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>