<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="row g-3">

    <div class="col-md-3 col-6">
        <div class="stat-card">
            <h4 class="text-primary">120</h4>
            <p>Patients</p>
            <i class="fas fa-user-injured stat-icon text-primary"></i>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card">
            <h4 class="text-success">25</h4>
            <p>Doctors</p>
            <i class="fas fa-user-md stat-icon text-success"></i>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card">
            <h4 class="text-warning">45</h4>
            <p>Appointments</p>
            <i class="fas fa-calendar-check stat-icon text-warning"></i>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="stat-card">
            <h4 class="text-danger">৳50K</h4>
            <p>Revenue</p>
            <i class="fas fa-money-bill stat-icon text-danger"></i>
        </div>
    </div>

</div>

<div class="row mt-4">

    <div class="col-md-8">
        <div class="card p-3">
            <h5>Patient Growth</h5>
            <canvas id="chart"></canvas>
        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('chart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        datasets: [{
            label: 'Patients',
            data: [10, 20, 15, 30, 25, 40],
            borderColor: '#6366f1',
            fill: false,
            tension: 0.4
        }]
    }
});
</script>

<?= $this->endSection() ?>