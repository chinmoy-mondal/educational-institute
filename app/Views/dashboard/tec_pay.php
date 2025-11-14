<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Teacher Earnings Dashboard</h3>

    <div class="row">
        <?php if (!empty($teachers)): ?>
            <?php foreach ($teachers as $t): ?>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1"><?= esc($t['name']) ?></h6>
                            <p class="mb-2" style="font-size: 0.85rem;">
                                <strong>Total:</strong> $<?= number_format($t['total_earned'], 2) ?>
                            </p>
                            <form method="post" action="<?= base_url('admin/reset_amount/' . $t['id']) ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-danger btn-block">
                                    Reset
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No teachers found</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>