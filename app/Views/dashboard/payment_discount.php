<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Apply Discount</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="post" action="<?= base_url('admin/submitStudentPaymentWithDiscount') ?>">
                <?= csrf_field() ?>
                <?php foreach ($fees as $index => $feeId): ?>
                <input type="hidden" name="fee_id[]" value="<?= $feeId ?>">
                <input type="hidden" name="amount[]" value="<?= $amounts[$index] ?>">
                <input type="hidden" name="month[]" value="<?= $months[$index] ?>">

                <div class="mb-2">
                    <label>Discount for Fee <?= esc($this->feesModel->find($feeId)['title']) ?>:</label>
                    <input type="number" step="0.01" name="discount[]" class="form-control" value="0">
                </div>
                <?php endforeach; ?>

                <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                <input type="hidden" name="receiver_id" value="<?= $student['receiver_id'] ?? 0 ?>">

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Submit & Generate Receipt</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>