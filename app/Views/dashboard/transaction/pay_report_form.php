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

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" value="<?= $_GET['start_date'] ?? '' ?>"
                            class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" value="<?= $_GET['end_date'] ?? '' ?>" class="form-control"
                            required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Transaction Type</label>
                        <select name="type" class="form-control" id="transactionType">
                            <option value="all_transaction">All Transactions</option>
                            <option value="student" <?= (($_GET['type'] ?? '') == 'student') ? 'selected' : '' ?>>
                                Student</option>
                            <option value="teacher" <?= (($_GET['type'] ?? '') == 'teacher') ? 'selected' : '' ?>>
                                Teacher</option>
                            <option value="salary" <?= (($_GET['type'] ?? '') == 'salary') ? 'selected' : '' ?>>Salary
                            </option>
                            <option value="cost" <?= (($_GET['type'] ?? '') == 'cost') ? 'selected' : '' ?>>Cost
                            </option>
                        </select>
                    </div>

                    <div class="col-md-3 d-none" id="teacherField">
                        <label class="form-label fw-semibold">Teacher Name</label>
                        <select name="teacher_name" class="form-control">
                            <option value="all_teacher">All Teachers</option>
                            <?php foreach ($teacherList ?? [] as $t): ?>
                            <option value="<?= esc($t['receiver_name']) ?>"
                                <?= (($_GET['teacher_name'] ?? '') == $t['receiver_name']) ? 'selected' : '' ?>>
                                <?= esc($t['receiver_name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            Generate Report
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- REPORT -->
    <?php if (!empty($report)): ?>

    <?php
        $totalEarn = 0;
        $totalCost = 0;
        $totalDiscount = 0;
        $seenDiscount = [];
        ?>

    <div class="card mt-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">📊 Report Result</h5>


            <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1"
                class="btn btn-warning btn-sm shadow-sm fw-bold">

                📥 Download Excel

            </a>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered">

                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Discount</th>
                        <th>Month</th>
                        <th>Description</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($report as $key => $row): ?>

                    <?php
                            $tid = $row['transaction_id'] ?? '-';
                            $amount = floatval($row['amount'] ?? 0);
                            $discount = floatval($row['discount'] ?? 0);
                            $status = $row['status'] ?? 0;

                            // Earn vs Cost
                            if ($status == 0) {
                                $totalEarn += $amount;
                            } else {
                                $totalCost += $amount;
                            }

                            // Discount (unique)
                            $showDiscount = true;
                            if ($discount > 0) {
                                if (isset($seenDiscount[$tid])) {
                                    $showDiscount = false;
                                } else {
                                    $totalDiscount += $discount;
                                    $seenDiscount[$tid] = true;
                                }
                            }
                            ?>

                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>

                        <td>
                            <a href="<?= site_url('admin/receipt/' . esc($tid)) ?>" target="_blank">
                                <?= esc($tid) ?>
                            </a>
                        </td>

                        <td><?= $row['sender_name'] ?? '-' ?></td>
                        <td><?= $row['receiver_name'] ?? '-' ?></td>

                        <td>
                            <?php if ($status == 0): ?>
                            <span class="badge bg-success">Earn</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Cost</span>
                            <?php endif; ?>
                        </td>

                        <td class="fw-bold"><?= number_format($amount, 2) ?></td>

                        <td>
                            <?php if ($discount > 0 && $showDiscount): ?>
                            <span class="text-warning fw-bold"><?= number_format($discount, 2) ?></span>
                            <?php else: ?>
                            —
                            <?php endif; ?>
                        </td>

                        <td><?= date('F', strtotime($row['created_at'])) ?></td>
                        <td><?= $row['description'] ?? '-' ?></td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>

                <tfoot>

                    <tr>
                        <th colspan="6" class="text-end text-success">Total Earn</th>
                        <th><?= number_format($totalEarn, 2) ?></th>
                        <th colspan="3"></th>
                    </tr>

                    <tr>
                        <th colspan="6" class="text-end text-danger">Total Cost</th>
                        <th><?= number_format($totalCost, 2) ?></th>
                        <th colspan="3"></th>
                    </tr>

                    <tr>
                        <th colspan="6" class="text-end text-warning">Total Discount</th>
                        <th><?= number_format($totalDiscount, 2) ?></th>
                        <th colspan="3"></th>
                    </tr>

                    <tr class="table-primary fw-bold">
                        <th colspan="6" class="text-end">Final Net Amount</th>
                        <th>
                            <?= number_format($totalEarn - $totalCost - $totalDiscount, 2) ?>
                        </th>
                        <th colspan="3"></th>
                    </tr>

                </tfoot>

            </table>

        </div>
    </div>

    <?php endif; ?>

</div>

<!-- JS -->
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

    toggleTeacherField();
    typeSelect.addEventListener("change", toggleTeacherField);
});
</script>

<?= $this->endSection() ?>