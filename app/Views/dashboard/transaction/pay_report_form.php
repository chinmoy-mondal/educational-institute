<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <h3 class="fw-bold text-primary mb-4">
        📊 Payment Report
    </h3>

    <!-- ================= FILTER CARD ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <form method="get" class="row g-3">

                <!-- Start Date -->
                <div class="col-md-3">
                    <label class="form-label">Start Date</label>
                    <input type="date" name="start_date" class="form-control"
                        value="<?= esc($_GET['start_date'] ?? '') ?>">
                </div>

                <!-- End Date -->
                <div class="col-md-3">
                    <label class="form-label">End Date</label>
                    <input type="date" name="end_date" class="form-control" value="<?= esc($_GET['end_date'] ?? '') ?>">
                </div>

                <!-- Type Filter -->
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-control">
                        <option value="all" <?= (($_GET['type'] ?? 'all') == 'all') ? 'selected' : '' ?>>All</option>
                        <option value="income" <?= (($_GET['type'] ?? '') == 'income') ? 'selected' : '' ?>>Income
                        </option>
                        <option value="expense" <?= (($_GET['type'] ?? '') == 'expense') ? 'selected' : '' ?>>Expense
                        </option>
                        <option value="student_payment"
                            <?= (($_GET['type'] ?? '') == 'student_payment') ? 'selected' : '' ?>>
                            Student Payment
                        </option>
                        <option value="teacher_payment"
                            <?= (($_GET['type'] ?? '') == 'teacher_payment') ? 'selected' : '' ?>>
                            Teacher Payment
                        </option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        🔍 Generate Report
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= REPORT TABLE ================= -->
    <div class="card shadow-sm">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="fw-bold">📄 Transaction Report</span>

            <?php if (!empty($_GET['start_date']) && !empty($_GET['end_date'])): ?>
                <a href="<?= base_url('admin/pay_report_csv?start_date=' . ($_GET['start_date'] ?? '') . '&end_date=' . ($_GET['end_date'] ?? '') . '&type=' . ($_GET['type'] ?? 'all')) ?>"
                    class="btn btn-success btn-sm">
                    ⬇ Download CSV
                </a>
            <?php endif; ?>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($report)): ?>
                        <?php $i = 1; ?>
                        <?php foreach ($report as $row): ?>
                            <tr>
                                <td><?= $i++ ?></td>

                                <td>
                                    <?= date('d M Y, h:i A', strtotime($row['created_at'])) ?>
                                </td>

                                <td>
                                    <span class="badge bg-info text-dark">
                                        <?= esc($row['activity'] ?? 'N/A') ?>
                                    </span>
                                </td>

                                <td class="text-start">
                                    <?= esc($row['description'] ?? '-') ?>
                                </td>

                                <td class="fw-bold text-success">
                                    ৳ <?= number_format($row['amount'] ?? 0, 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-danger">
                                No transactions found for selected filters
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>