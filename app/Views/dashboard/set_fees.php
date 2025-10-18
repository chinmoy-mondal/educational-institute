<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Set Fees</h4>
        </div>

        <div class="card-body">
            <!-- ✅ Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- ✅ Add Fees Form -->
            <form action="<?= base_url('admin/save_fees') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="title" class="form-label">Fees Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="e.g., Admission Fees" required>
                    </div>

                    <div class="col-md-6">
                        <label for="total_fees" class="form-label">Total Fees (৳)</label>
                        <input type="number" step="0.01" name="total_fees" id="total_fees" class="form-control" placeholder="e.g., 2000" required>
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
                            <th>Title</th>
                            <th>Total Fees (৳)</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fees as $f): ?>
                            <tr>
                                <td><?= esc($f['id']) ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td><?= esc(number_format($f['total_fees'], 2)) ?></td>
                                <td><?= esc($f['created_at'] ?? '-') ?></td>
                                <td><?= esc($f['updated_at'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No fees records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>