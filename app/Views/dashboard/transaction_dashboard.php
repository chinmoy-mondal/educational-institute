<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <h3 class="mb-4">Transaction Dashboard</h3>

    <!-- Summary Boxes -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= number_format($totalEarn, 2) ?> ৳</h3>
                    <p>Total Earn</p>
                </div>
                <div class="icon"><i class="fas fa-arrow-up"></i></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3><?= number_format($totalCost, 2) ?> ৳</h3>
                    <p>Total Cost</p>
                </div>
                <div class="icon"><i class="fas fa-arrow-down"></i></div>
            </div>
        </div>
    </div>

    <!-- Daily Graph -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Daily Earn vs Cost (This Month)</h5>
        </div>
        <div class="card-body">
            <canvas id="dailyChart" height="120"></canvas>
        </div>
    </div>

    <!-- Monthly Graph -->
    <div class="card">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Monthly Earn vs Cost (<?= date('Y') ?>)</h5>
        </div>
        <div class="card-body">
            <canvas id="monthChart" height="120"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // ---- DAILY GRAPH ----
    const dailyLabels = <?= json_encode($dailyLabels) ?>;
    const dailyEarns = <?= json_encode($dailyEarns) ?>;
    const dailyCosts = <?= json_encode($dailyCosts) ?>;

    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: dailyLabels,
            datasets: [{
                    label: 'Earn',
                    data: dailyEarns,
                    borderColor: 'green',
                    borderWidth: 2,
                    fill: false
                },
                {
                    label: 'Cost',
                    data: dailyCosts,
                    borderColor: 'red',
                    borderWidth: 2,
                    fill: false
                }
            ]
        }
    });

    // ---- MONTH GRAPH ----
    const monthLabels = <?= json_encode($monthLabels) ?>;
    const monthEarns = <?= json_encode($monthEarns) ?>;
    const monthCosts = <?= json_encode($monthCosts) ?>;

    new Chart(document.getElementById('monthChart'), {
        type: 'bar',
        data: {
            labels: monthLabels,
            datasets: [{
                    label: 'Earn',
                    data: monthEarns,
                    backgroundColor: 'green'
                },
                {
                    label: 'Cost',
                    data: monthCosts,
                    backgroundColor: 'red'
                }
            ]
        }
    });
</script>

<?= $this->endSection() ?>