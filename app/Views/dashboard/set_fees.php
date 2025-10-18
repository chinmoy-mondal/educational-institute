<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Set Fees Amount</h4>
            <form method="get" action="<?= base_url('admin/set_fees') ?>" class="d-flex align-items-center">
                <select name="class" class="form-select me-2" onchange="this.form.submit()">
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
                <form action="<?= base_url('admin/save_fees') ?>" method="post">
                    <?= csrf_field() ?>
                    <input type="hidden" name="class" value="<?= esc($selectedClass) ?>">

                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Fee Title</th>
                                <th width="200">Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]"
                                            value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                                            class="form-control" placeholder="Enter amount">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            <?php else: ?>
                <p class="text-muted">Please select a class to set fees.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>