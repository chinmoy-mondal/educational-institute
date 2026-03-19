<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <!-- Add Button -->
        <a href="<?= base_url('admin/holiday/add') ?>" class="btn btn-primary mt-3 mb-3">
            <i class="fas fa-plus"></i> Add Holiday
        </a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Holiday List</h3>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Holiday Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Total Days</th>
                            <th>Description</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (!empty($holidays)): ?>
                        <?php $i = 1; ?>
                        <?php $grandTotal = 0; ?>

                        <?php foreach ($holidays as $h): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= esc($h['name']) ?></td>
                            <td><?= esc($h['start_date']) ?></td>
                            <td><?= esc($h['end_date']) ?></td>

                            <!-- Days Calculation -->
                            <td>
                                <?php
                                        $start = new DateTime($h['start_date']);
                                        $end   = new DateTime($h['end_date']);
                                        $days  = $start->diff($end)->days + 1;

                                        echo $days;
                                        $grandTotal += $days;
                                        ?>
                            </td>

                            <td><?= esc($h['desc']) ?></td>

                            <td>
                                <a href="<?= base_url('admin/holiday/edit/' . $h['id']) ?>"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a href="<?= base_url('admin/holiday/delete/' . $h['id']) ?>"
                                    class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <!-- ✅ Grand Total Row -->
                        <tr style="background:#f4f6f9; font-weight:bold;">
                            <td colspan="4" class="text-right">Total Holiday Days</td>
                            <td><?= $grandTotal ?></td>
                            <td colspan="2"></td>
                        </tr>

                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                No holidays found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>