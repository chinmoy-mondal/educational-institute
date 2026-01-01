<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
// ---------------- CALCULATE TOTAL FEE ----------------
$totalFee = 0;

foreach ($fees as $f) {
    $unit   = $feeUnit[$f['id']] ?? 0;
    $amount = $feeAmounts[$f['id']] ?? 0;
    $totalFee += ($unit * $amount);
}

$discountAmount = is_numeric($student_discount) ? floatval($student_discount) : 0;
$netAmount = max($totalFee - $discountAmount, 0);
?>

<div class="container-fluid">
    <h4 class="mb-4">Student Payment Request</h4>

    <!-- ================= STUDENT PAYMENT FORM ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Student Payment Form</strong>
        </div>

        <div class="card-body">
            <form method="post" action="<?= base_url('admin/student-payment') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="step" value="discount">
                <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>">
                <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">
                <input type="hidden" name="net_amount" value="<?= $netAmount ?>">

                <!-- Fees Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">SL</th>
                                <th>Fee Title</th>
                                <th width="18%">Max Amount (৳)</th>
                                <th width="18%">Month</th>
                                <th width="18%">Pay Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            $months = [
                                '01' => 'January',
                                '02' => 'February',
                                '03' => 'March',
                                '04' => 'April',
                                '05' => 'May',
                                '06' => 'June',
                                '07' => 'July',
                                '08' => 'August',
                                '09' => 'September',
                                '10' => 'October',
                                '11' => 'November',
                                '12' => 'December'
                            ];
                            ?>
                            <?php foreach ($fees as $index => $f):
                                $unit   = $feeUnit[$f['id']] ?? 0;
                                $amount = $feeAmounts[$f['id']] ?? 0;
                                $max    = $unit * $amount;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td><?= $unit && $amount ? esc($unit . ' × ' . $amount) : '-' ?></td>
                                <td>
                                    <select name="month[<?= $index ?>]" class="form-select form-select-sm">
                                        <option value="">-- Select Month --</option>
                                        <?php foreach ($months as $key => $label): ?>
                                        <option value="<?= $key ?>"><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="fee_id[<?= $index ?>]" value="<?= esc($f['id']) ?>">
                                    <input type="number" step="0.01" name="amount[<?= $index ?>]"
                                        class="form-control form-control-sm" placeholder="Enter amount"
                                        max="<?= esc($max) ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Discount Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" name="discount" class="form-control"
                            value="<?= $discountAmount ?>">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="apply_discount" value="1"
                                id="applyDiscount">
                            <label class="form-check-label fw-semibold" for="applyDiscount">
                                Apply Discount
                            </label>
                        </div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <small class="text-muted">
                            If unchecked, discount will not be applied
                        </small>
                    </div>
                </div>

                <!-- Net Amount Section -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Fee (৳)</label>
                        <input type="text" class="form-control" value="<?= number_format($totalFee, 2) ?>" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="text" class="form-control" value="<?= number_format($discountAmount, 2) ?>"
                            readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">
                            Net Payable (৳)
                        </label>
                        <input type="text" class="form-control fw-bold text-success"
                            value="<?= number_format($netAmount, 2) ?>" readonly>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Next: Confirm Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>