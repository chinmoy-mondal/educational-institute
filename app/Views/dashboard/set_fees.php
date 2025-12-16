<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Fees Setup</h4>

    <!-- Select Class -->
    <form method="get" action="<?= base_url('admin/set_fees') ?>" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="class" class="form-select" onchange="this.form.submit()">
                    <option value="">Select Class</option>
                    <?php foreach ($classes as $classOption): ?>
                        <option value="<?= esc($classOption) ?>" <?= ($selectedClass == $classOption) ? 'selected' : '' ?>>
                            Class <?= esc($classOption) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </form>

    <?php if (!empty($selectedClass)): ?>
        <!-- Fees Setup Form -->
        <form method="post" action="<?= base_url('admin/save_fees') ?>">
            <input type="hidden" name="class" value="<?= esc($selectedClass) ?>">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <strong>Fees for Class <?= esc($selectedClass) ?></strong>
                </div>

                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Fees Title</th>
                                <th>Unit</th>
                                <th>Amount (৳)</th>
                                <th>Last Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sl = 1; ?>
                            <?php foreach ($titles as $t): ?>
                                <tr>
                                    <td><?= $sl++ ?></td>
                                    <td><?= esc($t['title']) ?></td>
                                    <td style="width: 120px;">
                                        <select name="unit[<?= $t['id'] ?>]" class="form-select form-select-sm">
                                            <option value="">Select</option>
                                            <option value="1" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '1') ? 'selected' : '' ?>>1</option>
                                            <option value="2" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '2') ? 'selected' : '' ?>>2</option>
                                            <option value="3" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '3') ? 'selected' : '' ?>>3</option>
                                            <option value="4" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '4') ? 'selected' : '' ?>>4</option>
                                            <option value="6" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '6') ? 'selected' : '' ?>>6</option>
                                            <option value="12" <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == '12') ? 'selected' : '' ?>>12</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="fees[<?= $t['id'] ?>]" class="form-control form-control-sm"
                                            value="<?= isset($existingAmounts[$t['id']]) ? esc($existingAmounts[$t['id']]) : '' ?>"
                                            placeholder="Enter amount">
                                    </td>
                                    <td>
                                        <?= isset($existingUpdates[$t['id']]) ? date('d M, Y h:i A', strtotime($existingUpdates[$t['id']])) : '-' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Fees
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- ✅ Show Total Amount -->
        <?php if (!empty($selectedClass)): ?>
            <div class="alert alert-info mt-3">
                <strong>Total Fees for Class <?= esc($selectedClass) ?>:</strong>
                <?= number_format($totalAmount, 2) ?> ৳
            </div>
        <?php endif; ?>

    <?php else: ?>
        <div class="alert alert-warning">Please select a class to view and set fees.</div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?> 