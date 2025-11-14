<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-4">Teacher Earnings Dashboard</h3>

    <div class="row">
        <?php if(!empty($teachers)): ?>
            <?php foreach($teachers as $t): ?>
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card card-widget widget-user shadow-sm">
                        <!-- Header / Background -->
                        <div class="widget-user-header bg-info">
                            <h5 class="widget-user-username"><?= esc($t['name']) ?></h5>
                            <h6 class="widget-user-desc"><?= esc($t['designation']) ?> - <?= esc($t['subject']) ?></h6>
                        </div>

                        <!-- Profile Image -->
                        <div class="widget-user-image">
                            <img class="img-circle elevation-2" 
                                 src="<?= $t['picture'] ? base_url('uploads/'.$t['picture']) : base_url('assets/img/default-user.png') ?>" 
                                 alt="Teacher Image">
                        </div>

                        <div class="card-footer">
                            <div class="row text-center">
                                <div class="col-6 border-right">
                                    <h6>Total Earned</h6>
                                    <p class="mb-0">$<?= number_format($t['total_earned'], 2) ?></p>
                                </div>
                                <div class="col-6">
                                    <h6>Status</h6>
                                    <span class="badge <?= $t['account_status']==1 ? 'bg-success' : 'bg-danger' ?>">
                                        <?= $t['account_status']==1 ? 'Active' : 'Inactive' ?>
                                    </span>
                                </div>
                            </div>
                            <form method="post" action="<?= base_url('admin/reset_amount/'.$t['id']) ?>" class="mt-3">
                                <?= csrf_field() ?>
                                <button type="submit" class="btn btn-danger btn-block">
                                    Reset Amount
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