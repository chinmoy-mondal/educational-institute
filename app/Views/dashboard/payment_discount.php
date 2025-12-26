<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Confirm Payment</h4>

    <form method="post" action="<?= base_url('admin/student-payment') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="step" value="final">

        <input type="hidden" name="student_id" value="<?= esc($student_id) ?>">
        <input type="hidden" name="receiver_id" value="<?= esc($receiver_id) ?>">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Fee</th>
                    <th>Month</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $i => $f): ?>
                <tr>
                    <td><?= esc($f['title']) ?></td>
                    <td><?= esc($f['month']) ?></td>
                    <td><?= esc($f['amount']) ?></td>
                </tr>

                <input type="hidden" name="fee_id[]" value="<?= esc($f['fee_id']) ?>">
                <input type="hidden" name="amount[]" value="<?= esc($f['amount']) ?>">
                <input type="hidden" name="month[]" value="<?= esc($f['month']) ?>">
                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if ($apply_discount): ?>
        <p><strong>Discount:</strong> ৳<?= esc($discount) ?></p>
        <input type="hidden" name="discount" value="<?= esc($discount) ?>">
        <input type="hidden" name="apply_discount" value="1">
        <?php endif; ?>

        <div class="text-end">
            <button class="btn btn-success">Confirm & Save</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>