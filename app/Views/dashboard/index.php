<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <!-- Summary Cards -->
        <div class="row">
            <!-- Total Students -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?= esc($total_students) ?></h3>
                        <p>Total Students</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-graduate"></i></div>
                    <a href="<?= base_url('admin/student') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>


            <!-- Teachers who gave marking -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= esc($totalSubjects > 0 ? $givenSubjects . ' / ' . $totalSubjects : 0) ?></h3>
                        <p>Subjects Marking</p>
                    </div>
                    <div class="icon"><i class="fas fa-book"></i></div>
                    <a href="<?= base_url('mark_given_teacher_list') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Total Teachers -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= esc($total_users) ?></h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon"><i class="fas fa-user-tie"></i></div>
                    <a href="<?= base_url('ad_teacher_list') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Leave Applications -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3><?= esc($total_new_users) ?></h3>
                        <p>New Users</p>
                    </div>
                    <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                    <a href="<?= base_url('ad_new_user') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Exams -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?= esc($total_applications) ?></h3>
                        <p>Applications</p>
                    </div>
                    <div class="icon"><i class="fas fa-pencil-ruler"></i></div>
                    <a href="<?= base_url('admin/exams') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Total Income -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>৳ <?= esc(number_format($total_income, 2)) ?></h3>
                        <p>Total Income</p>
                    </div>
                    <div class="icon"><i class="fas fa-coins"></i></div>
                    <a href="<?= base_url('admin/transactions') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Total Cost -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>৳ <?= esc(number_format($total_cost, 2)) ?></h3>
                        <p>Total Cost</p>
                    </div>
                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                    <a href="<?= base_url('admin/transactions') ?>" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- Total SMS Sent -->
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= esc($smsTotal) ?></h3>
                        <p>Total SMS Sent</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sms"></i>
                    </div>
                    <a href="<?= base_url('admin/sms-log') ?>" class="small-box-footer">
                        More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>


    </div>
</div>

<?= $this->endSection() ?>