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
                <h2 class="fw-bold">Attendance Calendar</h2>
                <p class="text-muted">Student attendance overview by date</p>
            </div>

            <?php if (!empty($attendances)): ?>
                <?php
                // Collect all dates
                $allDates = array_keys($attendances);
                sort($allDates);

                // Collect all student IDs
                $allStudents = [];
                foreach ($attendances as $date => $students) {
                    foreach ($students as $studentId => $records) {
                        $allStudents[$studentId] = true;
                    }
                }
                $allStudents = array_keys($allStudents);
                sort($allStudents);
                ?>

                <table class="table table-bordered table-sm text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Student ID</th>
                            <?php foreach ($allDates as $date): ?>
                                <th><?= esc(date('D d', strtotime($date))) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allStudents as $studentId): ?>
                            <tr>
                                <td class="fw-bold"><?= esc($studentId) ?></td>
                                <?php foreach ($allDates as $date): ?>
                                    <td
                                        <?php if (isset($attendances[$date][$studentId])): ?>
                                        title="<?php
                                                $times = array_column($attendances[$date][$studentId], 'time');
                                                $formattedTimes = array_map(fn($t) => date('h:i A', strtotime($t)), $times);
                                                echo esc(implode(', ', $formattedTimes));
                                                ?>"
                                        <?php endif; ?>>
                                        <?php if (isset($attendances[$date][$studentId])): ?>
                                            <?php
                                            $remarks = array_column($attendances[$date][$studentId], 'remark');
                                            echo esc(implode(', ', $remarks));
                                            ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info text-center">
                    No attendance records found.
                </div>
            <?php endif; ?>
        </div>
    </section>
    <!--end-->

</div>

<?= $this->include("layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>