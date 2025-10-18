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
                <form action="<?= base_url('admin/save_fees') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="class" value="<?= esc($selectedClass) ?>">

                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width:50px;">SL</th>
                                <th>Fee Title</th>
                                <th style="width:200px;">Last Update</th>
                                <th style="width:100px;">Unit</th>
                                <th style="width:200px;">Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <?= !empty($existingUpdates[$f['id']]) 
                                            ? date('d M, Y h:i A', strtotime($existingUpdates[$f['id']])) 
                                            : '<span class="text-muted">—</span>' ?>
                                    </td>
                                    <td>
                                        <select name="units[<?= $f['id'] ?>]" class="form-select">
                                            <option value="">Select</option>
                                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                                <option value="<?= $i ?>"
                                                    <?= isset($existingUnits[$f['id']]) && $existingUnits[$f['id']] == $i ? 'selected' : '' ?>>
                                                    <?= $i ?>
                                                </option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]"
                                            value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                                            class="form-control fee-input"
                                            placeholder="Enter amount">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-2">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
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