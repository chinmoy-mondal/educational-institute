<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Transaction Dashboard</h5>
                    <a href="<?= base_url('admin/add-transaction') ?>" class="btn btn-light btn-sm fw-bold">
                        + Add Transaction
                    </a>
                </div>
                <div class="card-body">

                    <!-- ✅ Earnings & Cost Summary -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card text-center border-success shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-success">Total Earn</h6>
                                    <h3 class="fw-bold text-success mb-0">
                                        ৳ <?= number_format($totalEarn ?? 0, 2) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center border-danger shadow-sm">
                                <div class="card-body">
                                    <h6 class="text-danger">Total Cost</h6>
                                    <h3 class="fw-bold text-danger mb-0">
                                        ৳ <?= number_format($totalCost ?? 0, 2) ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ✅ End Summary -->

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <!-- ✅ Chart Section -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">Earning vs Cost Graph</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="earnCostChart" height="100"></canvas>
                        </div>
                    </div>
                    <!-- ✅ End Chart -->

                    <!-- ✅ Transaction Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Transaction ID</th>
                                    <th>Sender</th>
                                    <th>Receiver</th>
                                    <th>Purpose</th>
                                    <th>Amount (৳)</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($transactions)): ?>
                                    <?php $i = 1; foreach ($transactions as $t): ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= esc($t['transaction_id']) ?></td>
                                            <td><?= esc($t['sender_name']) ?></td>
                                            <td><?= esc($t['receiver_name']) ?></td>
                                            <td>
                                                <?php if (stripos($t['purpose'], 'earn') !== false): ?>
                                                    <span class="badge bg-success"><?= esc($t['purpose']) ?></span>
                                                <?php elseif (stripos($t['purpose'], 'cost') !== false): ?>
                                                    <span class="badge bg-danger"><?= esc($t['purpose']) ?></span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary"><?= esc($t['purpose']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="fw-bold">
                                                <?= number_format($t['amount'], 2) ?>
                                            </td>
                                            <td><?= date('d M, Y', strtotime($t['created_at'])) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">No transactions found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- ✅ End Table -->

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('earnCostChart').getContext('2d');
    const earnCostChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Earn', 'Cost'],
            datasets: [{
                label: 'Amount (৳)',
                data: [<?= $totalEarn ?? 0 ?>, <?= $totalCost ?? 0 ?>],
                backgroundColor: ['#28a745', '#dc3545'],
                borderColor: ['#218838', '#c82333'],
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 100 }
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return '৳ ' + context.formattedValue;
                        }
                    }
                }
            }
        }
    });
</script>

<?= $this->endSection() ?>