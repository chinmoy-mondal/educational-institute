<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- SUCCESS MESSAGE -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- ERROR MESSAGE -->
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-3">
        <h4>Leave List</h4>

        <!-- NEW APPLICATION BUTTON -->
        <a href="<?= base_url('admin/leave_form') ?>" class="btn btn-primary">
            + New Application
        </a>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">All Leave Records</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php $i = 1; ?>

                    <?php if (!empty($leaves)): ?>
                    <?php foreach ($leaves as $leave): ?>
                    <tr>
                        <td><?= $i++ ?></td>

                        <td><?= esc($leave['leave_type']) ?></td>

                        <td>
                            <?= date('d M Y, h:i A', strtotime($leave['from_datetime'])) ?>
                        </td>

                        <td>
                            <?= date('d M Y, h:i A', strtotime($leave['to_datetime'])) ?>
                        </td>

                        <td><?= esc($leave['reason']) ?></td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($leave['status'] == 'Approved'): ?>
                            <span class="badge bg-success">Approved</span>
                            <?php elseif ($leave['status'] == 'Rejected'): ?>
                            <span class="badge bg-danger">Rejected</span>
                            <?php elseif ($leave['status'] == 'Cancelled'): ?>
                            <span class="badge bg-secondary">Cancelled</span>
                            <?php else: ?>
                            <span class="badge bg-warning">Pending</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= date('d M Y', strtotime($leave['created_at'])) ?>
                        </td>

                        <!-- ACTION -->
                        <td>
                            <a href="<?= base_url('admin/leave/edit/' . $leave['id']) ?>" class="btn btn-sm btn-info">
                                Edit
                            </a>

                            <a href="<?= base_url('admin/leave/delete/' . $leave['id']) ?>"
                                class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            No leave found
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>