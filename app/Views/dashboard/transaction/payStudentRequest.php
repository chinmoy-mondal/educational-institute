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

                <!-- Discount -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control"
                            value="<?= esc($student_discount ?? 0) ?>" min="0">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="applyDiscount" name="apply_discount"
                                value="1" <?= !empty($student_discount) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="applyDiscount">
                                Apply Discount
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <small class="text-muted">If unchecked, discount will be ignored</small>
                    </div>
                </div>

                <!-- Summary -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Entered Amount (৳)</label>
                        <input type="text" id="totalAmount" class="form-control" readonly value="0.00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">
                            Net Payable Amount (৳)
                        </label>
                        <input type="text" id="netAmount" class="form-control fw-bold text-success" readonly
                            value="0.00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Payment Status</label>
                        <div id="paymentStatus" class="alert alert-danger fw-bold mb-0">
                            ❌ Not Paid
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end mb-2">
                    <button type="submit" class="btn btn-primary">Next: Confirm Payment</button>

                </div>

            </form>
        </div>
    </div>
</div>

<script>
function calculateNet() {
    let total = 0;
    document.querySelectorAll('.fee-amount').forEach(input => {
        total += parseFloat(input.value) || 0;
    });

    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const applyDiscount = document.getElementById('applyDiscount').checked;

    let net = applyDiscount ? total - discount : total;
    if (net < 0) net = 0;

    document.getElementById('totalAmount').value = total.toFixed(2);
    document.getElementById('netAmount').value = net.toFixed(2);

    const statusBox = document.getElementById('paymentStatus');

    if (net === 0 && total > 0) {
        statusBox.className = 'alert alert-success fw-bold mb-0';
        statusBox.innerHTML = '✅ Paid';
    } else if (total === 0) {
        statusBox.className = 'alert alert-secondary fw-bold mb-0';
        statusBox.innerHTML = '— No Amount';
    } else {
        statusBox.className = 'alert alert-danger fw-bold mb-0';
        statusBox.innerHTML = '❌ Not Paid';
    }
}

/* ================== FIX START ================== */
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.fee-amount').forEach(input => {
        input.addEventListener('input', calculateNet);
    });

    document.getElementById('discount').addEventListener('input', calculateNet);
    document.getElementById('applyDiscount').addEventListener('change', calculateNet);

    // run once on page load
    calculateNet();
});
/* ================== FIX END ================== */
</script>

<?= $this->endSection() ?>