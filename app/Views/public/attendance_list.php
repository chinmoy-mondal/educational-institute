<!-- chinmoy is testing new code -->

<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

    <!--  Fixed Wrapper for Navbar -->
    <div class="fixed-header">
        <?= $this->include("layouts/base-structure/header"); ?>
    </div>
    <div class="container content">

        <!--start-->
        <section class="attendance-section py-5">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Attendance List</h2>
                    <p class="text-muted">Daily records of students</p>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Student ID</th>
                            <th>Remark</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($attendances)): ?>
                            <?php foreach ($attendances as $date => $students): ?>
                                <!-- Date Header Row -->
                                <tr class="table-info fw-bold">
                                    <td colspan="3">Date: <?= esc($date) ?></td>
                                </tr>

                                <?php foreach ($students as $studentId => $records): ?>
                                    <!-- Student Header Row -->
                                    <tr class="table-secondary">
                                        <td colspan="3">Student ID: <?= esc($studentId) ?></td>
                                    </tr>

                                    <?php foreach ($records as $rec): ?>
                                        <tr>
                                            <td><?= esc($studentId) ?></td>
                                            <td><?= esc($rec['remark']) ?></td>
                                            <td><?= esc($rec['time']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">No attendance records found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
        <!--end-->

    </div>

    <?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>