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
                <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>">
                <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">

                <!-- Month Selection -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Select Month</label>
                        <select name="month" class="form-select">
                            <?php
                            $months = [
                                1 => 'January',
                                2 => 'February',
                                3 => 'March',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'August',
                                9 => 'September',
                                10 => 'October',
                                11 => 'November',
                                12 => 'December'
                            ];
                            $currentMonth = date('n');
                            foreach ($months as $k => $v):
                            ?>
                            <option value="<?= $k ?>" <?= $k == $currentMonth ? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Fees Table -->
                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fee Title</th>
                                <th>Max Amount (৳)</th>
                                <th>Pay Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $i => $f): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td><?= number_format($f['annual_fee'], 2) ?></td>
                                <td>
                                    <input type="hidden" name="fee_id[<?= $i ?>]" value="<?= esc($f['id']) ?>">
                                    <input type="number" step="0.01" name="amount[<?= $i ?>]"
                                        class="form-control fee-amount" value="<?= number_format($f['amount'], 2) ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Discount -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" id="discount" name="discount" class="form-control"
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
                </div>

                <!-- Amount Summary -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Total Amount (৳)</label>
                        <input type="text" id="totalAmount" class="form-control" readonly value="0.00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">Net Amount (৳)</label>
                        <input type="text" id="netAmount" class="form-control fw-bold text-success" readonly
                            value="0.00">
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Confirm Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calculateNet() {
    let total = 0;
    document.querySelectorAll('input[name^="amount"]').forEach(input => {
        let val = parseFloat(input.value);
        if (!isNaN(val)) total += val;
    });
    let discount = parseFloat(document.getElementById('discount').value) || 0;
    let applyDiscount = document.getElementById('applyDiscount').checked;
    let net = applyDiscount ? total - discount : total;
    if (net < 0) net = 0;
    document.getElementById('totalAmount').value = total.toFixed(2);
    document.getElementById('netAmount').value = net.toFixed(2);
}

document.addEventListener('input', e => {
    if (e.target.matches('input[name^="amount"]') || e.target.matches('#discount')) calculateNet();
});
document.getElementById('applyDiscount').addEventListener('change', calculateNet);
window.addEventListener('load', calculateNet);
</script>

<?= $this->endSection() ?>