<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12 text-center mb-4">
            <h2 class="fw-bold">📊 Student Statistics</h2>
            <p class="text-muted">Overview of all registered students</p>
        </div>
    </div>

    <div class="row text-center">

        <!-- Total Students -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-primary"><?= $totalStudents ?></h4>
                    <p class="mb-0">Total Students</p>
                </div>
            </div>
        </div>

        <!-- Total Boys -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-info"><?= $totalBoys ?></h4>
                    <p class="mb-0">Boys</p>
                </div>
            </div>
        </div>

        <!-- Total Girls -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-danger"><?= $totalGirls ?></h4>
                    <p class="mb-0">Girls</p>
                </div>
            </div>
        </div>

        <!-- Sections -->
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0">
                <div class="card-body">
                    <h4 class="fw-bold text-success"><?= $totalSections ?></h4>
                    <p class="mb-0">Sections</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Students by Class -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="fw-bold mb-3">Students by Class</h4>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Class</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentsByClass as $row): ?>
                        <tr>
                            <td>Class <?= $row['class'] ?></td>
                            <td><?= $row['count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Students by Section -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h4 class="fw-bold mb-3">Students by Section</h4>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Section</th>
                        <th>Total Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($studentsBySection as $row): ?>
                        <tr>
                            <td>Section <?= $row['section'] ?></td>
                            <td><?= $row['count'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>