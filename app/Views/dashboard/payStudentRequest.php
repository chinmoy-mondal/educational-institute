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

                <!-- ================= MONTH SELECT ================= -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Month (up to)</label>
                        <select id="selectedMonth" class="form-select form-select-sm">
                            <?php
                            $currentMonth = date('n'); // 1-12
                            for ($m = 1; $m <= 12; $m++):
                                $monthName = date('F', mktime(0, 0, 0, $m, 1));
                            ?>
                            <option value="<?= $m ?>" <?= $m == $currentMonth ? 'selected' : '' ?>>
                                <?= $monthName ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" id="discount" class="form-control"
                            value="<?= esc($student_discount ?? 0) ?>">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="applyDiscount"
                                <?= !empty($student_discount) ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold">Apply Discount</label>
                        </div>
                    </div>
                </div>

                <!-- ================= FEES TABLE ================= -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fee Title</th>
                                <th>Amount (৳)</th>
                                <th>Unit (per year)</th>
                                <th>Total up to Selected Month (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $index => $f): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td>
                                    <input type="number" class="form-control fee-amount"
                                        value="<?= esc($f['amount']) ?>" data-unit="<?= esc($f['unit']) ?>">
                                    <input type="hidden" name="fee_id[<?= $index ?>]" value="<?= esc($f['id']) ?>">
                                </td>
                                <td><?= esc($f['unit']) ?></td>
                                <td>
                                    <input type="text" class="form-control total-per-fee" readonly value="0.00">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= AMOUNT SUMMARY ================= -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Amount (৳)</label>
                        <input type="text" id="totalAmount" class="form-control" readonly value="0.00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">Net Payable (৳)</label>
                        <input type="text" id="netAmount" class="form-control fw-bold text-success" readonly
                            value="0.00">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-danger">Due Amount (৳)</label>
                        <input type="text" id="dueAmount" class="form-control fw-bold text-danger" readonly
                            value="0.00">
                    </div>
                </div>

                <!-- ================= SUBMIT ================= -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Next: Confirm Payment</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
function calculateFees() {
    const selectedMonth = parseInt(document.getElementById('selectedMonth').value) || 1;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const applyDiscount = document.getElementById('applyDiscount').checked;

    let total = 0;

    document.querySelectorAll('.fee-amount').forEach((input, i) => {
        const feeAmount = parseFloat(input.value) || 0;
        const unit = parseInt(input.dataset.unit) || 1;

        // interval in months
        const interval = 12 / unit;
        // number of installments up to selected month
        const installments = Math.floor(selectedMonth / interval);
        const feeTotal = (feeAmount / unit) * installments;

        total += feeTotal;

        // update per-fee total
        document.querySelectorAll('.total-per-fee')[i].value = feeTotal.toFixed(2);
    });

    const net = applyDiscount ? total - discount : total;

    // paid amount from backend (if any)
    const paid = parseFloat("<?= $paidAmount ?? 0 ?>") || 0;
    const due = Math.max(net - paid, 0);

    document.getElementById('totalAmount').value = total.toFixed(2);
    document.getElementById('netAmount').value = net.toFixed(2);
    document.getElementById('dueAmount').value = due.toFixed(2);
}

// calculate whenever inputs change
document.addEventListener('input', calculateFees);
document.getElementById('selectedMonth').addEventListener('change', calculateFees);
document.getElementById('applyDiscount').addEventListener('change', calculateFees);

// initial calculation
window.addEventListener('load', calculateFees);
</script>

<?= $this->endSection() ?>