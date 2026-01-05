<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<?= $account_status ?>
<div class="container-fluid">
    <h3 class="mb-4">Teacher Earnings Dashboard</h3>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead class="thead-dark">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Teacher Name</th>
                        <th>Total Earned (৳)</th>
                        <th>Unpaid (৳)</th>
                        <th>Pay Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($teachers)): ?>
                    <?php $i = 1;
                        foreach ($teachers as $t): ?>
                    <tr class="text-center">
                        <td><?= $i++ ?></td>
                        <td class="text-left"><?= esc($t['name']) ?></td>
                        <td>৳ <?= number_format($t['total_earned'], 2) ?></td>
                        <td>৳ <?= number_format($t['unpaid'], 2) ?></td>

                        <?php if (!empty($account_status) && $account_status > 1): ?>
                        <!-- ✅ FORM -->
                        <form method="post" action="<?= base_url('admin/reset_amount/' . $t['id']) ?>">
                            <?= csrf_field() ?>
                            <td>
                                <input type="number" step="0.01" name="pay_amount"
                                    class="form-control form-control-sm text-center" max="<?= $t['unpaid'] ?>" required>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-sm btn-success">
                                    Pay <i class="fas fa-check"></i>
                                </button>
                            </td>
                        </form>
                        <?php else: ?>
                        <td colspan="2">
                            <span class="badge badge-secondary">
                                Not Eligible
                            </span>
                        </td>
                        <?php endif; ?>

                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No teachers found
                        </td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>