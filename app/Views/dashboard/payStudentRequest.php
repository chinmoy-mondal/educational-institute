<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

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

                <!-- ================= FEES TABLE ================= -->
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
                                        class="form-control form-control-sm fee-amount" placeholder="Enter amount"
                                        max="<?= esc($max) ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= DISCOUNT ================= -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" name="discount" id="discount" class="form-control"
                            value="<?= esc($student_discount ?? 0) ?>">
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

                <!-- ================= AMOUNT SUMMARY ================= -->
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
                </div>

                <!-- ================= SUBMIT ================= -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Next: Confirm Payment
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= PAYMENT HISTORY ================= -->
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <strong>Payment History</strong>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Receiver Name</th>
                        <th>Amount (৳)</th>
                        <th>Discount (৳)</th>
                        <th>Purpose</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pay_history)): $i = 1;
                        foreach ($pay_history as $p): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= esc($p['transaction_id']) ?></td>
                        <td><?= esc($p['receiver_name']) ?></td>
                        <td><?= number_format($p['amount'], 2) ?></td>
                        <td><?= number_format($p['discount'], 2) ?></td>
                        <td><?= esc($p['purpose']) ?></td>
                        <td><?= esc($p['description']) ?></td>
                        <td>
                            <span
                                class="badge bg-<?= $p['status'] == 'approved' ? 'success' : ($p['status'] == 'pending' ? 'warning' : 'danger') ?>">
                                <?= ucfirst($p['status']) ?>
                            </span>
                        </td>
                        <td><?= date('d M Y h:i A', strtotime($p['created_at'])) ?></td>
                    </tr>
                    <?php endforeach;
                    else: ?>
                    <tr>
                        <td colspan="9" class="text-muted py-3">No transaction history found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer text-end fw-bold">
            Total Paid: ৳ <?= number_format($totalPaid, 2) ?>
        </div>
    </div>
</div>

<!-- ================= JS LOGIC ================= -->
<script>
function calculateNet() {
    let total = 0;

    // Sum all fee amounts
    document.querySelectorAll('input[name^="amount"]').forEach(input => {
        let val = parseFloat(input.value);
        if (!isNaN(val)) total += val;
    });

    // Read discount value
    let discountInput = document.getElementById('discount');
    let discount = parseFloat(discountInput.value) || 0;

    // Apply discount only if checkbox checked
    let applyDiscount = document.getElementById('applyDiscount').checked;

    let net = applyDiscount ? (total - discount) : total;
    if (net < 0) net = 0;

    // Update UI fields
    document.getElementById('totalAmount').value = total.toFixed(2);
    document.getElementById('netAmount').value = net.toFixed(2);
}

// Recalculate on input change
document.addEventListener('input', function(e) {
    if (e.target.matches('input[name^="amount"]') || e.target.matches('#discount')) {
        calculateNet();
    }
});

// Recalculate when checkbox toggled
document.getElementById('applyDiscount').addEventListener('change', calculateNet);

// Initial calculation on page load
window.addEventListener('load', calculateNet);
</script>

<?= $this->endSection() ?>