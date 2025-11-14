<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <h3 class="mb-4">Teacher Payment Dashboard</h3>

    <!-- Teacher List -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Teachers List</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Role</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php $i = 1;
                        foreach ($users as $user): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($user['name']) ?></td>
                                <td><?= esc($user['mobile']) ?></td>
                                <td><?= esc($user['role']) ?></td>
                                <td>
                                    <?= $user['account_status'] == 1
                                        ? '<span class="badge bg-success">Active</span>'
                                        : '<span class="badge bg-danger">Inactive</span>' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No teachers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Records -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">All Teacher Transactions</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Teacher ID</th>
                        <th>Amount</th>
                        <th>Type</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transaction)): ?>
                        <?php $i = 1;
                        foreach ($transaction as $t): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($t['user_id']) ?></td>
                                <td><?= esc($t['amount']) ?></td>
                                <td><?= esc($t['type']) ?></td>
                                <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No transactions found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>