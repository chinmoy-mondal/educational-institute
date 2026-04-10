<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- Card -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt"></i> Generate Payment Report
            </h5>
        </div>

        <div class="card-body">

            <!-- FORM -->
            <form method="get" action="<?= base_url('admin/pay_report') ?>">

                <div class="row g-3">

                    <!-- Start Date -->
                    <div class="col-md-2">
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
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">End Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>"
                                class="form-control" required>
                        </div>
                    </div>

                    <!-- Transaction Type -->
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Transaction Type</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            <select name="type" class="form-control" id="transactionType">
                                <option value="all">All Transactions</option>
                                <option value="student" <?= (($_GET['type'] ?? '') == 'student') ? 'selected' : '' ?>>
                                    Student Payment
                                </option>
                                <option value="teacher" <?= (($_GET['type'] ?? '') == 'teacher') ? 'selected' : '' ?>>
                                    Teacher Payment
                                </option>
                                <option value="salary" <?= (($_GET['type'] ?? '') == 'salary') ? 'selected' : '' ?>>
                                    Salary
                                </option>
                                <option value="cost" <?= (($_GET['type'] ?? '') == 'cost') ? 'selected' : '' ?>>
                                    Cost / Expense
                                </option>
                            </select>
                        </div>
                    </div>

                    <!-- Teacher Name (Conditional Field) -->
                    <div class="col-md-3 d-none" id="teacherField">
                        <label class="form-label fw-semibold">Teacher Name</label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-user-tie"></i>
                            </span>

                            <select name="teacher_name" class="form-control">
                                <option value="">All Teachers</option>

                                <?php if (!empty($teacherList)): ?>
                                    <?php foreach ($teacherList as $t): ?>
                                        <option value="<?= esc($t['receiver_name']) ?>"
                                            <?= (($_GET['teacher_name'] ?? '') == $t['receiver_name']) ? 'selected' : '' ?>>
                                            <?= esc($t['receiver_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <!-- REPORT SECTION -->
    <?php if (!empty($report)): ?>

        <div class="card mt-4">
            <div class="card-header bg-success text-white d-flex justify-content-between">
                <h5 class="mb-0">📊 Report Result</h5>

                <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1" class="btn btn-light btn-sm">
                    📥 Download
                </a>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Transaction ID</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th>Type</th>
                            <th>Amount (৳)</th>
                            <th>Discount (৳)</th>
                            <th>Month</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $total = 0; ?>
                        <?php $seenDiscount = []; ?>

                        <?php foreach ($report as $key => $row): ?>

                            <?php
                            $tid = $row['transaction_id'] ?? '-';
                            $discount = floatval($row['discount'] ?? 0);
                            ?>

                            <tr>

                                <!-- Row number -->
                                <td><?= $key + 1 ?></td>

                                <!-- Date -->
                                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                                <!-- Transaction ID (CLICKABLE LINK) -->
                                <td>
                                    <a href="<?= site_url('admin/receipt/' . esc($tid)) ?>" target="_blank"
                                        class="text-primary fw-bold text-decoration-underline">
                                        <?= esc($tid) ?>
                                    </a>
                                </td>

                                <!-- Sender -->
                                <td><?= $row['sender_name'] ?? '-' ?></td>

                                <!-- Receiver -->
                                <td><?= $row['receiver_name'] ?? '-' ?></td>

                                <!-- Type -->
                                <td class="text-center">

                                    <?php if (($row['status'] ?? 0) == 0): ?>
                                        <span class="badge bg-success">Earn</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cost</span>
                                    <?php endif; ?>

                                </td>

                                <!-- Amount -->
                                <td class="fw-bold text-success">
                                    <?= number_format($row['amount'] ?? 0, 2) ?>
                                </td>

                                <!-- Discount (SHOW ONLY ONCE PER TRANSACTION ID) -->
                                <td class="fw-bold text-warning">

                                    <?php if ($discount > 0): ?>

                                        <?php if (isset($seenDiscount[$tid])): ?>
                                            <!-- duplicate → hide -->
                                            <span class="text-muted">—</span>
                                        <?php else: ?>
                                            <?= number_format($discount, 2) ?>
                                            <?php $seenDiscount[$tid] = true; ?>
                                        <?php endif; ?>

                                    <?php else: ?>
                                        —
                                    <?php endif; ?>

                                </td>

                                <!-- Month -->
                                <td>
                                    <?= date('F', strtotime($row['created_at'])) ?>
                                </td>

                                <!-- Description -->
                                <td>
                                    <?= $row['description'] ?? '-' ?>
                                </td>

                            </tr>

                            <?php
                            $total += ($row['amount'] - ($row['discount'] ?? 0));
                            ?>

                        <?php endforeach; ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Total</th>
                            <th class="text-success">
                                <?= number_format($total, 2) ?>
                            </th>
                            <th colspan="3"></th>
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

<!-- ================= JS ================= -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const typeSelect = document.getElementById("transactionType");
        const teacherField = document.getElementById("teacherField");

        function toggleTeacherField() {
            if (typeSelect.value === "teacher") {
                teacherField.classList.remove("d-none");
            } else {
                teacherField.classList.add("d-none");
            }
        }

        // initial load
        toggleTeacherField();

        // on change
        typeSelect.addEventListener("change", toggleTeacherField);
    });
</script>

<?= $this->endSection() ?>