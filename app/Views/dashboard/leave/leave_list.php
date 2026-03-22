<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- SUCCESS -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- ERROR -->
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php endif; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-3">
        <h4>Leave List</h4>

        <a href="<?= base_url('admin/leave_form') ?>" class="btn btn-primary">
            + New Application
        </a>
    </div>

    <!-- FILTER -->
    <div class="card mb-3">
        <div class="card-body">

            <form method="get" class="row">

                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search user, type, reason..."
                        value="<?= esc($_GET['search'] ?? '') ?>">
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">All Status</option>
                        <option value="Pending" <?= (($_GET['status'] ?? '') == 'Pending') ? 'selected' : '' ?>>Pending
                        </option>
                        <option value="Approved" <?= (($_GET['status'] ?? '') == 'Approved') ? 'selected' : '' ?>>
                            Approved</option>
                        <option value="Rejected" <?= (($_GET['status'] ?? '') == 'Rejected') ? 'selected' : '' ?>>
                            Rejected</option>
                        <option value="Cancelled" <?= (($_GET['status'] ?? '') == 'Cancelled') ? 'selected' : '' ?>>
                            Cancelled</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary btn-block">Filter</button>
                </div>

                <div class="col-md-2">
                    <a href="<?= base_url('admin/leave') ?>" class="btn btn-secondary btn-block">Reset</a>
                </div>

            </form>

        </div>
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
                        <th>User Name</th>
                        <th>Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Duration</th>
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

                    <?php
                            $from = new DateTime($leave['from_datetime']);
                            $to = new DateTime($leave['to_datetime']);
                            $diff = $from->diff($to);

                            $duration = $diff->d . 'd ' . $diff->h . 'h ' . $diff->i . 'm';
                            ?>

                    <tr>
                        <td><?= $i++ ?></td>

                        <td><?= esc($leave['user_name'] ?? 'N/A') ?></td>

                        <td><?= esc($leave['leave_type']) ?></td>

                        <td><?= date('d M Y, h:i A', strtotime($leave['from_datetime'])) ?></td>

                        <td><?= date('d M Y, h:i A', strtotime($leave['to_datetime'])) ?></td>

                        <td><?= $duration ?></td>

                        <td><?= esc($leave['reason']) ?></td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($leave['status'] == 'Approved'): ?>
                            <span class="badge badge-success">Approved</span>

                            <?php elseif ($leave['status'] == 'Rejected'): ?>
                            <span class="badge badge-danger">Rejected</span>

                            <?php elseif ($leave['status'] == 'Cancelled'): ?>
                            <span class="badge badge-secondary">Cancelled</span>

                            <?php else: ?>
                            <span class="badge badge-warning">Pending</span>
                            <?php endif; ?>
                        </td>

                        <td><?= date('d M Y', strtotime($leave['created_at'])) ?></td>

                        <!-- ACTION -->
                        <td>

                            <?php if ($leave['status'] == 'Approved'): ?>

                            <span class="text-muted">No actions</span>

                            <?php else: ?>

                            <!-- EDIT -->
                            <a href="<?= base_url('admin/leave_form/' . $leave['id']) ?>" class="btn btn-info btn-sm">
                                Edit
                            </a>

                            <!-- DELETE -->
                            <a href="<?= base_url('admin/leave/delete/' . $leave['id']) ?>"
                                class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                Delete
                            </a>

                            <!-- APPROVE (ADMIN ONLY) -->
                            <?php if (($loginUser['account_status'] ?? 0) > 1): ?>

                            <a href="<?= base_url('admin/leave/approved/' . $leave['id'] ) ?>"
                                class="btn btn-success btn-sm">
                                Approve
                            </a>

                            <?php endif; ?>

                            <?php endif; ?>

                        </td>

                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>

                    <tr>
                        <td colspan="10" class="text-center">No leave found</td>
                    </tr>

                    <?php endif; ?>

                </tbody>
            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>