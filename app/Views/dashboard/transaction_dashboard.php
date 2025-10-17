<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold text-primary mb-0">💰 Overview of earnings and expenses</h3>
            <small class="text-muted">Take a quick look at your transactions</small>
        </div>
    </div>

    <!-- ✅ Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-success mb-2">Total Earn</h6>
                    <h3 class="fw-bold text-success">৳ <?= number_format($totalEarn ?? 0, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-danger mb-2">Total Cost</h6>
                    <h3 class="fw-bold text-danger">৳ <?= number_format($totalCost ?? 0, 2) ?></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-info bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-info mb-2">Net Balance</h6>
                    <h3 class="fw-bold text-info">৳ <?= number_format(($totalEarn ?? 0) - ($totalCost ?? 0), 2) ?></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Date-wise Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Last 7 Days Report</h6>
                </div>
                <div class="card-body">
                    <canvas id="dateChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- Month-wise Chart -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Month-wise Report (<?= date('Y') ?>)</h6>
                </div>
                <div class="card-body">
                    <canvas id="monthChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ All Transactions Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">All Transactions</h6>
            <span class="badge bg-light text-dark"><?= count($transactions) ?> Records</span>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Purpose</th>
                        <th>Amount (৳)</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php $i = 1; foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                                <td><?= esc($t['transaction_id']) ?></td>
                                <td><?= esc($t['sender_name']) ?></td>
                                <td><?= esc($t['receiver_name']) ?></td>
                                <td>
                                    <?php if (stripos($t['purpose'], 'Earn') !== false): ?>
                                        <span class="badge bg-success"><?= esc($t['purpose']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><?= esc($t['purpose']) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold <?= (stripos($t['purpose'], 'Earn') !== false) ? 'text-success' : 'text-danger' ?>">
                                    <?= number_format($t['amount'], 2) ?>
                                </td>
                                <td><?= esc($t['description']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted">No transactions found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ✅ Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Date-wise Chart
    const dateCtx = document.getElementById('dateChart').getContext('2d');
    new Chart(dateCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dateLabels ?? []) ?>,
            datasets: [
                {
                    label: 'Earn (৳)',
                    data: <?= json_encode($dateEarns ?? []) ?>,
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderRadius: 6
                },
                {
                    label: 'Cost (৳)',
                    data: <?= json_encode($dateCosts ?? []) ?>,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // Month-wise Chart
    const monthCtx = document.getElementById('monthChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthLabels ?? []) ?>,
            datasets: [
                {
                    label: 'Earn (৳)',
                    data: <?= json_encode($monthEarns ?? []) ?>,
                    borderColor: 'rgb(25, 135, 84)',
                    backgroundColor: 'rgba(25, 135, 84, 0.2)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Cost (৳)',
                    data: <?= json_encode($monthCosts ?? []) ?>,
                    borderColor: 'rgb(220, 53, 69)',
                    backgroundColor: 'rgba(220, 53, 69, 0.2)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } },
            scales: { y: { beginAtZero: true } }
        }
    });
</script>

<?= $this->endSection() ?>