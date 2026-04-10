<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- ================= HEADER ================= -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-primary mb-1">💰 Financial Overview</h2>
            <small class="text-muted">Earnings, expenses and analytics dashboard</small>
        </div>
    </div>

    <?php if (($account_status ?? 0) > 1): ?>

        <!-- ================= KPI CARDS ================= -->
        <div class="row g-3 mb-4">

            <!-- Earn -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-success bg-gradient text-white rounded-3">
                    <div class="card-body">
                        <h6 class="opacity-75">Total Earn</h6>
                        <h3 class="fw-bold">৳ <?= number_format($totalEarn ?? 0, 2) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Cost -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-danger bg-gradient text-white rounded-3">
                    <div class="card-body">
                        <h6 class="opacity-75">Total Cost</h6>
                        <h3 class="fw-bold">৳ <?= number_format($totalCost ?? 0, 2) ?></h3>
                    </div>
                </div>
            </div>

            <!-- Balance -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm bg-primary bg-gradient text-white rounded-3">
                    <div class="card-body">
                        <h6 class="opacity-75">Net Balance</h6>
                        <h3 class="fw-bold">৳ <?= number_format(($totalEarn ?? 0) - ($totalCost ?? 0), 2) ?></h3>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= CHARTS ================= -->
        <div class="row g-4 mb-4">

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>Today</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="todayChart" height="140"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>Monthly</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="dailyChart" height="140"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white">
                        <strong>Yearly</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="monthChart" height="140"></canvas>
                    </div>
                </div>
            </div>

        </div>

    <?php endif; ?>

    <!-- ================= TABLE CARD ================= -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <div>
                <strong>Transactions</strong>
                <small class="ms-2 opacity-75">(<?= count($transactions) ?> records)</small>
            </div>

            <a href="<?= current_url() . '?' . http_build_query($_GET) ?>&download=1" class="btn btn-light btn-sm">
                ⬇ Export
            </a>
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Sender</th>
                            <th>Receiver</th>
                            <th class="text-end">Amount</th>
                            <th>Description</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $typeLabels = [
                            'student' => 'Student',
                            'teacher' => 'Teacher',
                            'salary'  => 'Salary',
                            'cost'    => 'Expense'
                        ];
                        ?>

                        <?php foreach ($transactions as $i => $t): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>

                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $typeLabels[$t['status']] ?? 'Other' ?>
                                    </span>
                                </td>

                                <td><?= esc($t['sender_name']) ?></td>
                                <td><?= esc($t['receiver_name']) ?></td>

                                <td class="text-end fw-bold <?= $t['status'] == 0 ? 'text-success' : 'text-danger' ?>">
                                    ৳ <?= number_format($t['amount'] - ($t['discount'] ?? 0), 2) ?>
                                </td>

                                <td class="text-muted"><?= esc($t['description']) ?></td>
                            </tr>
                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<?= $this->endSection() ?>