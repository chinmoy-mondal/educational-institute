<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Payment - Discount</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Confirm Payment with Discount</strong>
        </div>

        <div class="card-body">
            <form method="post" action="<?= base_url('admin/student-payment') ?>">
                <?= csrf_field() ?>

                <input type="hidden" name="step" value="final">
                <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>">
                <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">

                <!-- ================= FEES TABLE ================= -->
                <div class="table-responsive mb-4">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Fee Title</th>
                                <th>Month</th>
                                <th>Pay Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $index => $f): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <input type="hidden" name="fee_id[<?= $index ?>]" value="<?= esc($f['fee_id']) ?>">
                                        <input type="text" name="month[<?= $index ?>]" class="form-control form-control-sm"
                                            value="<?= esc($f['month']) ?>" readonly>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="amount[<?= $index ?>]"
                                            class="form-control form-control-sm" value="<?= esc($f['amount']) ?>" readonly>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= DISCOUNT SECTION ================= -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Discount (৳)</label>
                        <input type="number" step="0.01" name="discount" class="form-control"
                            value="<?= esc($discount ?? 0) ?>">
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="apply_discount" value="1"
                                id="applyDiscount" <?= !empty($apply_discount) ? 'checked' : '' ?>>
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

                <!-- ================= SUBMIT ================= -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Finalize Payment
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>