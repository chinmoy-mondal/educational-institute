<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Set Fees Amount</h4>
        </div>

        <div class="card-body">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Select Class -->
            <form method="get" action="<?= base_url('admin/set_fees') ?>" class="d-flex mb-3">
                <select name="class" class="form-select me-2" style="width:150px;" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $cls): ?>
                        <option value="<?= $cls ?>" <?= ($selectedClass == $cls ? 'selected' : '') ?>>
                            Class <?= $cls ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>

            <?php if ($selectedClass): ?>
                <form method="post" action="<?= base_url('admin/save_fees') ?>">

    <!-- ✅ Class selector -->
    <div class="row mb-3">
        <div class="col-md-4">
            <select name="class" class="form-select" onchange="this.form.submit()">
                <option value="">Select Class</option>
                <?php foreach ($classes as $c): ?>
                    <option value="<?= esc($c) ?>" <?= ($selectedClass == $c) ? 'selected' : '' ?>>
                        <?= esc($c) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php if (!empty($selectedClass)): ?>
        <!-- ✅ Fees table -->
        <table class="table table-bordered align-middle">
    <thead class="table-dark">
        <tr>
            <th>SL</th>
            <th>Fee Title</th>
            <th>Last Update</th>
            <th>Unit</th>
            <th width="200">Amount (৳)</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; foreach ($fees as $f): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= esc($f['title']) ?></td>
                <td><?= esc($existingUpdates[$f['id']] ?? '—') ?></td>
                <td>
                    <select name="units[<?= $f['id'] ?>]" class="form-select">
                        <option value="">Select</option>
                        <?php for ($u = 1; $u <= 12; $u++): ?>
                            <option value="<?= $u ?>"
                                <?= isset($existingUnits[$f['id']]) && $existingUnits[$f['id']] == $u ? 'selected' : '' ?>>
                                <?= $u ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </td>
                <td>
                    <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]"
                        value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                        class="form-control" placeholder="Enter amount">
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- ✅ ADD THIS BLOCK RIGHT HERE -->
<?php if (!empty($selectedClass)): ?>
    <div class="alert alert-info mt-3">
        <strong>Total Fees for Class <?= esc($selectedClass) ?>:</strong>
        <?= number_format($totalAmount, 2) ?> ৳
    </div>
<?php endif; ?>
<!-- ✅ END -->

<div class="text-end mt-3">
    <button type="submit" class="btn btn-success">Save</button>
</div>

        <!-- ✅ Total Fees Section -->
        <div class="alert alert-info mt-3">
            <strong>Total Fees for Class <?= esc($selectedClass) ?>:</strong>
            <?= number_format($totalAmount, 2) ?> ৳
        </div>

        <!-- ✅ Save Button -->
        <button type="submit" class="btn btn-primary mt-2">Save</button>
    <?php endif; ?>

</form>

            <?php else: ?>
                <p class="text-muted">Please select a class to set fees.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.fee-input');
    inputs.forEach((input, index) => {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown' && inputs[index + 1]) {
                e.preventDefault();
                inputs[index + 1].focus();
            } else if (e.key === 'ArrowUp' && inputs[index - 1]) {
                e.preventDefault();
                inputs[index - 1].focus();
            }
        });
    });
});
</script>

<?= $this->endSection() ?>
