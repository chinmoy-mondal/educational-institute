<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Set Fees Amount</h4>

            <!-- ✅ Separate GET form for class selection -->
            <form method="get" action="<?= base_url('admin/set_fees') ?>" class="d-flex align-items-center">
                <select name="class" class="form-select me-2" style="width:150px;" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $cls): ?>
                        <option value="<?= $cls ?>" <?= ($selectedClass == $cls ? 'selected' : '') ?>>
                            Class <?= $cls ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>
        </div>

        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if ($selectedClass): ?>
                <!-- ✅ Separate POST form for saving fees -->
                <form action="<?= base_url('admin/save_fees') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="class" value="<?= esc($selectedClass) ?>">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Class <?= esc($selectedClass) ?></h5>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>

                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width:60px;">SL</th>
                                <th>Fee Title</th>
                                <th style="width:180px;">Last Updated</th>
                                <th style="width:200px;">Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <?= !empty($existingAmounts[$f['id'] . '_updated'])
                                            ? date('d M, Y h:i A', strtotime($existingAmounts[$f['id'] . '_updated']))
                                            : '<span class="text-muted">—</span>' ?>
                                    </td>
                                    <td>
                                        <input type="number" step="0.01"
                                            name="fees[<?= $f['id'] ?>]"
                                            value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                                            class="form-control fee-input"
                                            placeholder="Enter amount">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <p class="text-muted">Please select a class to set fees.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ✅ Keyboard Navigation -->
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