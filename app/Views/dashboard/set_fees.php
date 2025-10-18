<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Set Fees Amount</h4>
        </div>

        <div class="card-body">
            <!-- ✅ Display any validation errors or success message -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- ✅ Fees form -->
            <form action="<?= base_url('admin/save_fees') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="class" class="form-label">Class</label>
                        <select name="class" id="class" class="form-select" required>
                            <option value="">Select Class</option>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="title_id" class="form-label">Title</label>
                        <select name="title_id" id="title_id" class="form-select" required>
                            <option value="">Select Title</option>
                            <?php if (!empty($titles)): ?>
                                <?php foreach ($titles as $title): ?>
                                    <option value="<?= esc($title['id']) ?>">
                                        <?= esc($title['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="fees" class="form-label">Fees Amount (৳)</label>
                        <input type="number" step="0.01" name="fees" id="fees" class="form-control" placeholder="Enter Amount" required>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ✅ Existing Fees List -->
    <div class="card mt-4 shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Existing Fees Records</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($fees)): ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Class</th>
                            <th>Title</th>
                            <th>Fees (৳)</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fees as $f): ?>
                            <tr>
                                <td><?= esc($f['id']) ?></td>
                                <td>Class <?= esc($f['class']) ?></td>
                                <td><?= esc($f['title_name'] ?? 'N/A') ?></td>
                                <td><?= esc(number_format($f['fees'], 2)) ?></td>
                                <td><?= esc($f['created_at']) ?></td>
                                <td><?= esc($f['updated_at']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No fee records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>