<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Set Fees</h4>
        </div>

        <div class="card-body">
            <!-- ✅ Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- ✅ Fees Table -->
            <?php if (!empty($fees)): ?>
                <form action="<?= base_url('admin/update_fees') ?>" method="post">
                    <?= csrf_field() ?>

                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 60px;">ID</th>
                                <th>Title</th>
                                <th style="width: 200px;">Fees (৳)</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= esc($f['id']) ?></td>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]" 
                                               value="<?= esc($f['total_fees']) ?>" class="form-control" required>
                                    </td>
                                    <td class="text-center">
                                        <button type="submit" name="update_id" value="<?= $f['id'] ?>" 
                                                class="btn btn-success btn-sm">Save</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
            <?php else: ?>
                <p class="text-muted">No fees records found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>