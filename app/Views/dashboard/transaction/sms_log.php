<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Pagination CSS -->
<style>
    /* Pagination wrapper */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        list-style: none;
        padding-left: 0;
        margin: 0;
        flex-wrap: wrap;
    }

    /* Each page item */
    .pagination li {
        margin: 0 3px;
    }

    /* Page links as buttons */
    .pagination li a {
        display: block;
        padding: 6px 14px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        color: #007bff;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* Hover effect */
    .pagination li a:hover {
        background-color: #0069d9;
        color: #fff;
        border-color: #0062cc;
    }

    /* Active page */
    .pagination li.active a {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
        cursor: default;
    }

    /* Disabled page (optional) */
    .pagination li.disabled a {
        color: #6c757d;
        pointer-events: none;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
</style>

<div class="container-fluid">
    <h4 class="mb-4">SMS History</h4>

    <!-- Status Filter -->
    <form method="get" action="<?= base_url('admin/sms-log') ?>" class="mb-4">
        <div class="row g-2 align-items-center">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="1" <?= (isset($selectedStatus) && $selectedStatus == '1') ? 'selected' : '' ?>>Sent
                    </option>
                    <option value="0" <?= (isset($selectedStatus) && $selectedStatus == '0') ? 'selected' : '' ?>>Failed
                    </option>
                </select>
            </div>
        </div>
    </form>

    <!-- Flash message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <?php if (!empty($smsList)): ?>

        <!-- Total Sent / Failed SMS Boxes -->
        <div class="row mb-3">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= esc($smsTotal) ?></h3>
                        <p>Total Sent SMS</p>
                    </div>
                    <div class="icon"><i class="fas fa-check-circle"></i></div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?= esc($smsFailed) ?></h3>
                        <p>Total Failed SMS</p>
                    </div>
                    <div class="icon"><i class="fas fa-times-circle"></i></div>
                </div>
            </div>
        </div>

        <!-- SMS Log Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <strong>SMS Log List</strong>
                <a href="<?= base_url('admin/resend-failed-sms') ?>" class="btn btn-warning btn-sm">
                    <i class="fas fa-redo"></i> Resend All Failed SMS
                </a>
            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-striped align-middle text-sm">
                    <thead class="table-light">
                        <tr>
                            <th>SL</th>
                            <th>Student Name</th>
                            <th>Phone Number</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Sent At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl = 1; ?>
                        <?php foreach ($smsList as $sms): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= esc($sms['student_name'] ?? '-') ?></td>
                                <td><?= esc($sms['phone_number'] ?? '-') ?></td>
                                <td><?= esc($sms['message'] ?? '-') ?></td>
                                <td>
                                    <?php if (($sms['status'] ?? 0) == 1): ?>
                                        <span class="badge bg-success">Sent</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Failed</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= isset($sms['created_at']) ? date('d M, Y h:i A', strtotime($sms['created_at'])) : '-' ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer pagination-footer">
                <?= $pager->links() ?>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-warning">No SMS records found.</div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>