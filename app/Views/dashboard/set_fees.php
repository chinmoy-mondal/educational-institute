<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Fees Setup</h4>

    <!-- Select Class & Section -->
    <form method="get" action="<?= base_url('admin/set_fees') ?>" class="mb-4">
        <div class="row g-2 align-items-center">

            <!-- Class -->
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

            <!-- Section -->
            <?php if (!empty($selectedClass)): ?>
            <div class="col-md-4">
                <select name="section" class="form-select" onchange="this.form.submit()">
                    <option value="">শাখা নির্বাচন করুন</option>
                    <?php foreach ($sections as $sec): ?>
                    <option value="<?= esc($sec) ?>" <?= ($selectedSection == $sec) ? 'selected' : '' ?>>
                        <?= esc($sec) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

        </div>
    </form>

    <?php if (!empty($selectedClass) && !empty($selectedSection)): ?>

    <!-- Fees Setup Form -->
    <form method="post" action="<?= base_url('admin/save_fees') ?>">
        <input type="hidden" name="class" value="<?= esc($selectedClass) ?>">
        <input type="hidden" name="section" value="<?= esc($selectedSection) ?>">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>
                    Fees for Class <?= esc($selectedClass) ?> – <?= esc($selectedSection) ?>
                </strong>
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

                            <!-- Unit -->
                            <td style="width:120px;">
                                <select name="unit[<?= $t['id'] ?>]" class="form-select form-select-sm">
                                    <option value="">Select</option>
                                    <?php foreach ([1, 2, 3, 4, 6, 12] as $u): ?>
                                    <option value="<?= $u ?>"
                                        <?= (isset($existingUnits[$t['id']]) && $existingUnits[$t['id']] == $u) ? 'selected' : '' ?>>
                                        <?= $u ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <!-- Amount -->
                            <td>
                                <input type="number" name="fees[<?= $t['id'] ?>]" class="form-control form-control-sm"
                                    placeholder="Enter amount"
                                    value="<?= isset($existingAmounts[$t['id']]) ? esc($existingAmounts[$t['id']]) : '' ?>">
                            </td>

                            <!-- Updated -->
                            <td>
                                <?= isset($existingUpdates[$t['id']])
                                            ? date('d M, Y h:i A', strtotime($existingUpdates[$t['id']]))
                                            : '-' ?>
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

    <!-- Total -->
    <div class="alert alert-info mt-3">
        <strong>
            Total Fees (Class <?= esc($selectedClass) ?> – <?= esc($selectedSection) ?>):
        </strong>
        <?= number_format($totalAmount, 2) ?> ৳
    </div>

    <?php else: ?>

    <div class="alert alert-warning">
        Please select both <strong>Class</strong> and <strong>Section</strong> to view and set fees.
    </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>