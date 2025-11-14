<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <h3 class="mb-4">Teacher Payment Dashboard</h3>

    <!-- Teacher List with Total Earned -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Teachers Earnings</h5>
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
                        <th>Total Earned</th>
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
                                <td><?= number_format($t['total_earned'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">No teachers found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>