<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <form method="post" action="<?= base_url('admin/confirm-payment') ?>">

        <div class="row g-3">

            <!-- ================= SELECT MONTH ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Pay Month</label>
                <select id="payMonth" class="form-select">
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                    <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- ================= SAMPLE FEES ================= -->
            <?php foreach ($fees as $fee): ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold"><?= esc($fee['title']) ?></label>
                <input type="number" class="form-control fee-amount" data-base="<?= $fee['amount'] ?>"
                    data-unit="<?= $fee['unit'] ?>" value="0">
            </div>
            <?php endforeach; ?>

            <!-- ================= DISCOUNT ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Discount (৳)</label>
                <input type="number" step="0.01" id="discount" class="form-control" value="0">
                <div class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" name="apply_discount" value="1">
                    <label class="form-check-label fw-semibold">Save for next</label>
                </div>
            </div>

            <!-- ================= TOTAL ENTERED ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Total Entered Amount (৳)</label>
                <input type="text" id="totalAmount" class="form-control" readonly>
            </div>

            <!-- ================= NET PAYABLE ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Net Payable Amount (৳)</label>
                <input type="text" id="netAmount" class="form-control" readonly>
            </div>

            <!-- ================= FULL TOTAL PAYMENT ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Full Total Payment (৳)</label>
                <input type="text" id="fullTotalPayment" class="form-control" readonly
                    value="<?= esc(($totalPaid ?? 0) + ($totalDiscount ?? 0)) ?>">
            </div>

            <!-- ================= FINAL AMOUNT ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Final Amount (৳)</label>
                <input type="text" id="final_amount" class="form-control fw-bold text-success" readonly>
            </div>

            <!-- ================= TOTAL FOR MONTH ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Total for Selected Month (৳)</label>
                <input type="text" id="monthTotal" class="form-control" readonly data-raw="0.00">
            </div>

            <!-- ================= NEED TO PAY ================= -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Need to Pay (৳)</label>
                <input type="text" id="needTotal" class="form-control fw-bold text-danger text-end" readonly>
            </div>

        </div>

        <!-- ================= FOOTER ================= -->
        <div class="d-flex justify-content-between align-items-center mt-4">

            <button type="submit" class="btn btn-primary">
                Confirm Payment
            </button>

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

<!-- ================= SCRIPT ================= -->
<script>
function calculateNet() {

    let totalEntered = 0;
    document.querySelectorAll('.fee-amount').forEach(i => {
        totalEntered += parseFloat(i.value) || 0;
    });

    document.getElementById('totalAmount').value = totalEntered.toFixed(2);

    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const netPayable = Math.max(totalEntered - discount, 0);
    document.getElementById('netAmount').value = netPayable.toFixed(2);

    const previousTotal =
        parseFloat(document.getElementById('fullTotalPayment').value) || 0;

    const finalAmount = previousTotal + totalEntered;
    document.getElementById('final_amount').value = finalAmount.toFixed(2);

    const monthTotal =
        parseFloat(document.getElementById('monthTotal').dataset.raw) || 0;

    const needToPay = Math.max(monthTotal - finalAmount, 0);
    document.getElementById('needTotal').value = needToPay.toFixed(2);

    const box = document.getElementById('paymentStatusBox');
    const input = document.getElementById('paymentStatus');

    if (monthTotal > 0 && needToPay === 0) {
        box.className = 'alert alert-success fw-bold mb-0 text-end';
        box.innerHTML = '✅ Paid';
        input.value = 1;
    } else if (monthTotal === 0) {
        box.className = 'alert alert-secondary fw-bold mb-0 text-end';
        box.innerHTML = '— Preview Only';
        input.value = 0;
    } else {
        box.className = 'alert alert-danger fw-bold mb-0 text-end';
        box.innerHTML = '❌ Not Paid';
        input.value = 0;
    }
}

function showMonthFeePreview() {

    const month = parseInt(document.getElementById('payMonth').value);
    let total = 0;

    document.querySelectorAll('.fee-amount').forEach(input => {

        const base = parseFloat(input.dataset.base) || 0;
        const unit = parseInt(input.dataset.unit) || 1;

        let times = 1;
        if (unit > 1) {
            const interval = 12 / unit;
            times = Math.min(Math.floor(month / interval), unit);
        }

        const amount = base * times;
        input.value = amount.toFixed(2);
        total += amount;
    });

    document.getElementById('monthTotal').dataset.raw = total.toFixed(2);
    document.getElementById('monthTotal').value = total.toFixed(2);

    calculateNet();
}

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.fee-amount')
        .forEach(i => i.addEventListener('input', calculateNet));

    document.getElementById('discount')
        .addEventListener('input', calculateNet);

    document.getElementById('payMonth')
        .addEventListener('change', showMonthFeePreview);

    showMonthFeePreview();
});
</script>

<?= $this->endSection() ?>