<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">SMS History</h4>

    <!-- Optional: Filter by Status -->
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

    <?php if (!empty($smsList)): ?>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>SMS Log</strong>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-bordered table-striped align-middle text-sm">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Mobile</th>
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
                        <td><?= esc($sms['mobile']) ?></td>
                        <td><?= esc($sms['message']) ?></td>
                        <td>
                            <?php if ($sms['status'] == 1): ?>
                            <span class="badge bg-success">Sent</span>
                            <?php else: ?>
                            <span class="badge bg-danger">Failed</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d M, Y h:i A', strtotime($sms['created_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total Sent SMS -->
    <div class="alert alert-info mt-3">
        <strong>Total Sent SMS:</strong> <?= esc($smsTotal) ?>
    </div>

    <?php else: ?>

    <div class="alert alert-warning">
        No SMS records found.
    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>