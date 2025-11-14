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
                        <th>Designation</th>
                        <th>Subject</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($teachers)): ?>
                        <?php $i = 1;
                        foreach ($teachers as $t): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($t['name']) ?></td>
                                <td><?= esc($t['designation']) ?></td>
                                <td><?= esc($t['subject']) ?></td>
                                <td><?= esc($t['phone']) ?></td>
                                <td><?= esc($t['email']) ?></td>
                                <td>
                                    <?= $t['account_status'] == 1
                                        ? '<span class="badge bg-success">Active</span>'
                                        : '<span class="badge bg-danger">Inactive</span>' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No teachers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Transaction Records -->
    <div class="card">
        <div class="card-header bg-success text-white">
            <h5 class="mb-0">All Transactions</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Amount</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php $i = 1;
                        foreach ($transactions as $tr): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($tr['transaction_id']) ?></td>
                                <td><?= esc($tr['sender_name']) ?></td>
                                <td><?= esc($tr['receiver_name']) ?></td>
                                <td><?= esc($tr['amount']) ?></td>
                                <td><?= esc($tr['purpose']) ?></td>
                                <td>
                                    <?= $tr['status'] == 1
                                        ? '<span class="badge bg-success">Completed</span>'
                                        : '<span class="badge bg-warning">Pending</span>' ?>
                                </td>
                                <td><?= date('d M Y', strtotime($tr['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No transactions found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>