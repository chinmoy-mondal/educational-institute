<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Fees Setup (Section Wise)</h4>

    <!-- Select Section Only -->
    <form method="get" action="<?= base_url('admin/set_fees') ?>" class="mb-4">
        <div class="row g-2 align-items-center">

            <div class="col-md-4">
                <select name="section" class="form-select" onchange="this.form.submit()">
                    <option value="">শাখা নির্বাচন করুন</option>
                    <option value="আবাসিক" <?= ($selectedSection == 'আবাসিক') ? 'selected' : '' ?>>
                        আবাসিক
                    </option>
                    <option value="অনাবাসিক" <?= ($selectedSection == 'অনাবাসিক') ? 'selected' : '' ?>>
                        অনাবাসিক
                    </option>
                </select>
            </div>

        </div>
    </form>

    <?php if (!empty($selectedSection)): ?>

    <!-- Fees Setup Form -->
    <form method="post" action="<?= base_url('admin/save_fees') ?>">
        <input type="hidden" name="section" value="<?= esc($selectedSection) ?>">

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>
                    Fees for <?= esc($selectedSection) ?>
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

    <!-- Total Amount -->
    <div class="alert alert-info mt-3">
        <strong>
            Total Fees (<?= esc($selectedSection) ?>):
        </strong>
        <?= number_format($totalAmount, 2) ?> ৳
    </div>

    <?php else: ?>

    <div class="alert alert-warning">
        অনুগ্রহ করে একটি <strong>শাখা</strong> নির্বাচন করুন।
    </div>

    <?php endif; ?>
</div>

<?= $this->endSection() ?>