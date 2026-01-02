<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Payment Request</h4>

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

                <!-- Month Selection -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Month (for preview)</label>
                        <?php
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
                        $currentMonth = date('m');
                        ?>
                        <select name="month" id="payMonth" class="form-select">
                            <?php foreach ($months as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $key == $currentMonth ? 'selected' : '' ?>><?= $label ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Fees Table -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">SL</th>
                                <th>Fee Title</th>
                                <th width="18%">Max Amount (৳)</th>
                                <th width="18%">Pay Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            foreach ($fees as $index => $f):
                                $unit   = $feeUnit[$f['id']] ?? 0;
                                $amount = $feeAmounts[$f['id']] ?? 0;
                                $max    = $unit * $amount;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td><?= $unit && $amount ? esc($unit . ' × ' . $amount) : '-' ?></td>
                                <td>
                                    <input type="hidden" name="fee_id[<?= $index ?>]" value="<?= esc($f['id']) ?>">
                                    <input type="number" step="0.01" name="amount[<?= $index ?>]"
                                        class="form-control form-control-sm fee-amount" data-unit="<?= esc($unit) ?>"
                                        data-base="<?= esc($amount) ?>" data-title="<?= esc($f['title']) ?>"
                                        data-max="<?= esc($max) ?>" value="0.00" min="0">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Discount + Last Totals -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control"
                            value="<?= esc($student_discount ?? 0) ?>" min="0">

                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="applyDiscount" name="apply_discount"
                                value="1" <?= !empty($student_discount) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="applyDiscount">Save for next</label>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Full Total Payment (৳)</label>
                        <input type="text" name="full_total_payment" class="form-control" id="fullTotalPayment" readonly
                            value="<?= esc(($totalPaid ?? 0)) ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Last Total Payment (৳)</label>
                        <input type="text" class="form-control" id="lastPaid" readonly
                            value="<?= esc(($totalPaid ?? 0) - ($totalDiscount ?? 0)) ?>">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Last Total Discount (৳)</label>
                        <input type="text" class="form-control" id="lastDiscount" readonly
                            value="<?= esc($totalDiscount ?? 0) ?>">
                    </div>
                </div>

                <!-- Summary -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total Entered Amount (৳)</label>
                        <input type="text" id="totalAmount" class="form-control" readonly value="0.00">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-success">Net Payable Amount (৳)</label>
                        <input type="text" id="netAmount" class="form-control fw-bold text-success" readonly
                            value="0.00">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Final Amount (৳)</label>
                        <input type="text" id="final_amount" name="final_amount"
                            class="form-control fw-bold text-success" readonly data-raw="0.00" value="0.00">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Total for Selected Month (৳)</label>
                        <input type="text" id="monthTotal" class="form-control" readonly data-raw="0.00" value="0.00">
                    </div>
                </div>

                <!-- Submit & Payment Status -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <button type="submit" class="btn btn-primary">Next: Confirm Payment</button>
                    </div>

                    <div class="col-md-3 p-0">
                        <label class="form-label fw-semibold mb-1">Payment Status</label>
                        <div id="paymentStatusBox" class="alert alert-secondary fw-bold mb-0 text-end">
                            — Preview Only
                        </div>
                        <input type="hidden" name="payment_status" id="paymentStatus" value="0">
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
/* ================== CALCULATE TOTALS ================== */
function calculateNet() {
    let totalEntered = 0;
    document.querySelectorAll('.fee-amount').forEach(input => {
        totalEntered += parseFloat(input.value) || 0;
    });

    const discount = parseFloat(document.getElementById('discount').value) || 0;

    // Total Entered Amount (this payment only)
    document.getElementById('totalAmount').value = totalEntered.toFixed(2);

    // Full Total Payment (previous payments + discounts)
    const fullTotalPayment = parseFloat(document.getElementById('fullTotalPayment').value) || 0;

    // Final Amount = Full Total Payment + Total Entered Amount
    const finalAmount = fullTotalPayment + totalEntered;
    document.getElementById('final_amount').value = finalAmount.toFixed(2);

    // Net Payable = Total Entered - Discount
    const netPayable = Math.max(totalEntered - discount, 0);
    document.getElementById('netAmount').value = netPayable.toFixed(2);

    // Total for selected month
    const monthTotalRaw = parseFloat(document.getElementById('monthTotal').dataset.raw || 0) || 0;
    document.getElementById('monthTotal').value = monthTotalRaw.toFixed(2);

    // Payment Status: Final Amount >= Month Total → Paid
    const statusBox = document.getElementById('paymentStatusBox');
    const statusInput = document.getElementById('paymentStatus');

    if (finalAmount >= monthTotalRaw && monthTotalRaw > 0) {
        statusBox.className = 'alert alert-success fw-bold mb-0 text-end';
        statusBox.innerHTML = '✅ Paid';
        statusInput.value = '1';
    } else if (monthTotalRaw === 0) {
        statusBox.className = 'alert alert-secondary fw-bold mb-0 text-end';
        statusBox.innerHTML = '— Preview Only';
        statusInput.value = '0';
    } else {
        statusBox.className = 'alert alert-danger fw-bold mb-0 text-end';
        statusBox.innerHTML = '❌ Not Paid';
        statusInput.value = '0';
    }
}

/* ================== MONTH PREVIEW ================== */
function showMonthFeePreview() {
    const month = parseInt(document.getElementById('payMonth').value);
    let totalMonth = 0;

    document.querySelectorAll('.fee-amount').forEach(input => {
        const unit = parseInt(input.dataset.unit) || 0;
        const base = parseFloat(input.dataset.base) || 0;

        let times = 1;
        if (unit > 1) {
            const interval = 12 / unit;
            times = Math.floor(month / interval);
            times = Math.min(times, unit);
        }

        const amount = times * base;
        input.value = amount.toFixed(2);
        totalMonth += amount;
    });

    document.getElementById('monthTotal').dataset.raw = totalMonth.toFixed(2);

    // Recalculate all totals
    calculateNet();
}

/* ================== EVENTS ================== */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.fee-amount').forEach(input => input.addEventListener('input', calculateNet));
    document.getElementById('discount').addEventListener('input', calculateNet);
    document.getElementById('payMonth').addEventListener('change', showMonthFeePreview);

    // Initial calculation
    showMonthFeePreview();
});
</script>

<?= $this->endSection() ?>