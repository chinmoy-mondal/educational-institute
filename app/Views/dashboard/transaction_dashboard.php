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
        <!-- 💰 Total Earn -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-success bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-white text-uppercase fw-semibold mb-2">
                        <i class="fas fa-arrow-up me-1"></i> Total Earn
                    </h6>
                    <h2 class="fw-bold text-white mb-0">
                        ৳ <?= number_format($totalEarn ?? 0, 2) ?>
                    </h2>
                </div>
            </div>
        </div>

        <!-- 💸 Total Cost -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-danger bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-white text-uppercase fw-semibold mb-2">
                        <i class="fas fa-arrow-down me-1"></i> Total Cost
                    </h6>
                    <h2 class="fw-bold text-white mb-0">
                        ৳ <?= number_format($totalCost ?? 0, 2) ?>
                    </h2>
                </div>
            </div>
        </div>

        <!-- ⚖️ Net Balance -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-info bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="text-info text-white fw-semibold mb-2">
                        <i class="fas fa-balance-scale me-1"></i> Net Balance
                    </h6>
                    <h2 class="fw-bold text-white mb-0">
                        ৳ <?= number_format(($totalEarn ?? 0) - ($totalCost ?? 0), 2) ?>
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Today + Month + Year Charts Row -->
    <div class="row g-4 mb-4">

        <!-- ⭐ TODAY REPORT -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Today's Report (<?= date('d M Y') ?>)</h6>
                </div>
                <div class="card-body">
                    <canvas id="todayChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- ⭐ CURRENT MONTH -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Current Month Report (<?= date('F Y') ?>)</h6>
                </div>
                <div class="card-body">
                    <canvas id="dailyChart" height="150"></canvas>
                </div>
            </div>
        </div>

        <!-- ⭐ YEARLY -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Yearly Summary (<?= date('Y') ?>)</h6>
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

            <!-- ✅ Pagination ABOVE the table -->
            <?php if (!empty($pager)): ?>
                <div class="mb-3 d-flex justify-content-center">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>

            <table class="table table-striped align-middle mb-0">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Transaction ID</th>
                        <th>Sender</th>
                        <th>Receiver</th>
                        <th>Type</th>
                        <th>Amount (৳)</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($transactions)): ?>
                        <?php $i = ($pager->getTotal() ?? count($transactions)) - (($pager->getCurrentPage() - 1) * $pager->getPerPage()); ?>
                        <?php foreach ($transactions as $t): ?>
                            <tr>
                                <td><?= $i-- ?></td>
                                <td><?= date('d M Y', strtotime($t['created_at'])) ?></td>
                                <td><?= esc($t['transaction_id']) ?></td>
                                <td><?= esc($t['sender_name']) ?></td>
                                <td><?= esc($t['receiver_name']) ?></td>
                                <td>
                                    <?php if ($t['status'] == 0): ?>
                                        <span class="badge bg-success">Earn</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Cost</span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold <?= $t['status'] == 0 ? 'text-success' : 'text-danger' ?>">
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

<!-- ✅ Chart.js + Tooltip Fix -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    /* -----------------------------------------------------------
   ⭐ TODAY'S GRAPH
----------------------------------------------------------- */
    const todayCtx = document.getElementById('todayChart').getContext('2d');
    new Chart(todayCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($todayLabels ?? []) ?>,
            datasets: [{
                    label: 'Earn (৳)',
                    data: <?= json_encode($todayEarns ?? []) ?>,
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderRadius: 6
                },
                {
                    label: 'Cost (৳)',
                    data: <?= json_encode($todayCosts ?? []) ?>,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Time (Hours)'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (৳)'
                    }
                }
            }
        }
    });

    /* -----------------------------------------------------------
       ⭐ CURRENT MONTH GRAPH
    ----------------------------------------------------------- */
    const dailyCtx = document.getElementById('dailyChart').getContext('2d');
    new Chart(dailyCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($dailyLabels ?? []) ?>,
            datasets: [{
                    label: 'Earn (৳)',
                    data: <?= json_encode($dailyEarns ?? []) ?>,
                    backgroundColor: 'rgba(25, 135, 84, 0.7)',
                    borderRadius: 6
                },
                {
                    label: 'Cost (৳)',
                    data: <?= json_encode($dailyCosts ?? []) ?>,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)',
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (৳)'
                    }
                }
            }
        }
    });

    /* -----------------------------------------------------------
       ⭐ YEARLY GRAPH
    ----------------------------------------------------------- */
    const monthCtx = document.getElementById('monthChart').getContext('2d');
    new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthLabels ?? []) ?>,
            datasets: [{
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
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Month'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (৳)'
                    }
                }
            }
        }
    });
</script>

<style>
    .card-body canvas {
        pointer-events: auto !important;
    }
</style>

<?= $this->endSection() ?>