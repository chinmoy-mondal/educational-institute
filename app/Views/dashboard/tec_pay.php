<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Teacher Earnings Dashboard</h3>

    <div class="row">
        <?php if (!empty($teachers)): ?>
            <?php foreach ($teachers as $t): ?>
                <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-top border-primary shadow-sm">
                        <div class="card-body text-center p-3">
                            <!-- Teacher Name -->
                            <h6 class="card-title font-weight-bold mb-2"><?= esc($t['name']) ?></h6>

                            <!-- Designation / Subject -->
                            <p class="text-muted mb-2" style="font-size: 0.75rem;">
                                <?= esc($t['designation']) ?> - <?= esc($t['subject']) ?>
                            </p>

                            <!-- Total Earned -->
                            <p class="mb-2" style="font-size: 0.9rem;">
                                <span class="text-success font-weight-bold">$<?= number_format($t['total_earned'], 2) ?></span>
                            </p>

                            <!-- Reset Button -->
                            <form method="post" action="<?= base_url('admin/reset_amount/' . $t['id']) ?>">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-sm btn-outline-danger btn-block">
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