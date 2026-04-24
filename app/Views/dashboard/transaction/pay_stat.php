<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- SUMMARY CARDS -->
    <div class="row">

        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5>Total Earn</h5>
                    <h3><?= number_format($totalEarn, 2) ?> ৳</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5>Total Cost</h5>
                    <h3><?= number_format($totalCost, 2) ?> ৳</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5>Total Discount</h5>
                    <h3><?= number_format($totalDiscount ?? 0, 2) ?> ৳</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5>Net Balance</h5>
                    <h3><?= number_format($net, 2) ?> ৳</h3>
                </div>
            </div>
        </div>

    </div>

    <!-- SECOND ROW CARDS -->
    <div class="row mt-3">

        <div class="col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6>Residential Income</h6>
                    <h4><?= number_format($residential ?? 0, 2) ?> ৳</h4>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card bg-secondary text-white">
                <div class="card-body">
                    <h6>Non-Residential Income</h6>
                    <h4><?= number_format($nonResidential ?? 0, 2) ?> ৳</h4>
                </div>
            </div>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="row mt-4">

        <!-- Monthly Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Monthly Earn vs Cost</div>
                <div class="card-body">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Earn vs Cost</div>
                <div class="card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- RESIDENTIAL CHART -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Residential vs Non-Residential</div>
                <div class="card-body">
                    <canvas id="resChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const monthlyData = <?= json_encode($monthlyData) ?>;

const labels = Object.keys(monthlyData);
const earnData = labels.map(m => monthlyData[m].earn);
const costData = labels.map(m => monthlyData[m].cost);

/* ================= BAR CHART ================= */
new Chart(document.getElementById('monthlyChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
                label: 'Earn',
                data: earnData
            },
            {
                label: 'Cost',
                data: costData
            }
        ]
    }
});

/* ================= PIE CHART ================= */
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: ['Earn', 'Cost'],
        datasets: [{
            data: [<?= $totalEarn ?>, <?= $totalCost ?>]
        }]
    }
});

/* ================= RESIDENTIAL CHART ================= */
new Chart(document.getElementById('resChart'), {
    type: 'doughnut',
    data: {
        labels: ['Residential', 'Non-Residential'],
        datasets: [{
            data: [
                <?= $residential ?? 0 ?>,
                <?= $nonResidential ?? 0 ?>
            ]
        }]
    }
});
</script>

<?= $this->endSection() ?>