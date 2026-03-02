<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h3><?= $title ?></h3>
                <!-- Optional: Button to refresh or add new salary -->
                <a href="<?= base_url('admin/salary') ?>" class="btn btn-primary">
                    <i class="fas fa-sync-alt"></i> Refresh
                </a>
            </div>
        </div>

        <?php $grandTotal = 0; ?>

        <!-- Loop Through Each Month -->
        <?php foreach ($salaryData as $month => $users): ?>
        <?php $monthTotal = 0; ?>
        <div class="card card-primary mb-4 shadow-sm">
            <div class="card-header">
                <h5 class="card-title mb-0"><?= $month ?></h5>
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-striped mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>User</th>
                            <th class="text-right">Amount (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user => $amount): ?>
                        <?php $monthTotal += $amount; ?>
                        <tr>
                            <td><?= esc($user) ?></td>
                            <td class="text-right"><?= number_format($amount, 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="bg-secondary text-white">
                        <tr>
                            <th>Total</th>
                            <th class="text-right"><?= number_format($monthTotal, 2) ?></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <?php $grandTotal += $monthTotal; ?>
        <?php endforeach; ?>

        <!-- Grand Total -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-success shadow">
                    <div class="card-body text-center">
                        <h4 class="mb-2">Total Salary Paid</h4>
                        <h2>৳ <?= number_format($grandTotal, 2) ?></h2>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>