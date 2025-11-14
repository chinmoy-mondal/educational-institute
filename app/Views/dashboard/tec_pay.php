<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Teacher Earnings Dashboard</h3>

    <div class="row">
        <?php if (!empty($teachers)): ?>
            <?php foreach ($teachers as $t): ?>
                <div class="col-lg-2 col-6 mb-3">
                    <div class="small-box bg-info">
                        <div class="inner text-center">
                            <h4>৳ <?= number_format($t['total_earned'], 2) ?></h4>
                            <p><?= esc($t['name']) ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <form method="post" action="<?= base_url('admin/reset_amount/' . $t['id']) ?>">
                            <?= csrf_field() ?>
                            <button type="submit" class="small-box-footer btn btn-sm btn-light btn-block">
                                Reset <i class="fas fa-redo"></i>
                            </button>
                        </form>
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