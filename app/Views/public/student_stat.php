<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!--  Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>
<div class="container content">

    <!--start-->
    <section class="student-statistics py-5">
        <div class="container">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="fw-bold text-primary">Student Statistics</h2>
                <p class="text-muted fs-5">Overview of Gender, Religion, and Total Students</p>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Gender Chart -->
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body text-center">
                            <h5 class="mb-3">Gender Distribution</h5>
                            <canvas id="genderChart" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Religion Chart -->
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body text-center">
                            <h5 class="mb-3">Religion Distribution</h5>
                            <canvas id="religionChart" style="height:250px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Total Students -->
                <div class="col-md-4">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body text-center">
                            <h5 class="mb-3">Total Students</h5>
                            <div class="display-4 fw-bold text-primary">
                                <?= $totalStudents ?? 0 ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gender Chart
        const genderCtx = document.getElementById('genderChart');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [<?= $maleCount ?? 0 ?>, <?= $femaleCount ?? 0 ?>],
                    backgroundColor: ['#0d6efd', '#e83e8c'],
                    borderWidth: 1
                }]
            }
        });

        // Religion Chart
        const religionCtx = document.getElementById('religionChart');
        new Chart(religionCtx, {
            type: 'doughnut',
            data: {
                labels: ['Hindu', 'Muslim'],
                datasets: [{
                    data: [<?= $hinduCount ?? 0 ?>, <?= $muslimCount ?? 0 ?>],
                    backgroundColor: ['#ffc107', '#198754'],
                    borderWidth: 1
                }]
            }
        });
    </script>
    <!--end-->

</div>

<?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>