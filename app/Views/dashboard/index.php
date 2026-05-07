<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Welcome,
                <?= esc(session()->get('user_name')) ?>
            </h2>

            <p class="text-muted mb-0">
                Clinic dashboard overview
            </p>
        </div>

    </div>

    <!-- STATS -->
    <div class="row g-4">

        <!-- TOTAL USERS -->
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body position-relative">

                    <h6 class="text-muted">
                        Total Users
                    </h6>

                    <h2 class="fw-bold">
                        <?= esc($total_users ?? 0) ?>
                    </h2>

                    <i class="fas fa-users fa-3x text-primary opacity-25 position-absolute"
                        style="right:20px; top:20px;"></i>

                </div>

            </div>

        </div>

        <!-- ACTIVE USERS -->
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body position-relative">

                    <h6 class="text-muted">
                        Active Users
                    </h6>

                    <h2 class="fw-bold text-success">
                        <?= esc($active_users ?? 0) ?>
                    </h2>

                    <i class="fas fa-user-check fa-3x text-success opacity-25 position-absolute"
                        style="right:20px; top:20px;"></i>

                </div>

            </div>

        </div>

        <!-- INACTIVE USERS -->
        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body position-relative">

                    <h6 class="text-muted">
                        Inactive Users
                    </h6>

                    <h2 class="fw-bold text-danger">
                        <?= esc($inactive_users ?? 0) ?>
                    </h2>

                    <i class="fas fa-user-times fa-3x text-danger opacity-25 position-absolute"
                        style="right:20px; top:20px;"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- SECOND ROW -->
    <div class="row mt-4 g-4">

        <!-- CHART -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h5 class="fw-semibold mb-4">
                        Patient Growth
                    </h5>

                    <canvas id="patientChart" height="100"></canvas>

                </div>

            </div>

        </div>

        <!-- APPOINTMENTS -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h5 class="fw-semibold mb-4">
                        Today's Appointments
                    </h5>

                    <!-- APPOINTMENT -->
                    <div class="d-flex align-items-center mb-3">

                        <img src="https://i.pravatar.cc/50?img=1" class="rounded-circle me-3" width="45">

                        <div>
                            <strong>Rahim</strong><br>

                            <small class="text-muted">
                                10:30 AM
                            </small>
                        </div>

                    </div>

                    <!-- APPOINTMENT -->
                    <div class="d-flex align-items-center mb-3">

                        <img src="https://i.pravatar.cc/50?img=2" class="rounded-circle me-3" width="45">

                        <div>
                            <strong>Karim</strong><br>

                            <small class="text-muted">
                                12:00 PM
                            </small>
                        </div>

                    </div>

                    <!-- APPOINTMENT -->
                    <div class="d-flex align-items-center">

                        <img src="https://i.pravatar.cc/50?img=3" class="rounded-circle me-3" width="45">

                        <div>
                            <strong>Sakib</strong><br>

                            <small class="text-muted">
                                2:15 PM
                            </small>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('patientChart'), {

    type: 'line',

    data: {

        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],

        datasets: [{
            label: 'Patients',

            data: [10, 20, 15, 30, 25, 40],

            borderColor: '#6366f1',

            tension: 0.4,

            fill: false
        }]
    }
});
</script>

<?= $this->endSection() ?>