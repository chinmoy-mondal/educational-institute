<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content">
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
                            <th>Name</th>
                            <th>Roll</th>
                            <?php foreach ($allDates as $date): ?>
                                <th><?= esc(date('D d', strtotime($date))) ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allStudents as $studentId): ?>
                            <?php
                            $studentName = $students[$studentId]['name'] ?? 'Unknown';
                            $studentRoll = $students[$studentId]['roll'] ?? '-';
                            ?>
                            <tr>
                                <td class="fw-bold"><?= esc($studentId) ?></td>
                                <td><?= esc($studentName) ?></td>
                                <td><?= esc($studentRoll) ?></td>

                                <?php foreach ($allDates as $date): ?>
                                    <?php
                                    if (isset($attendances[$date][$studentId])) {
                                        $times = array_column($attendances[$date][$studentId], 'time');
                                        sort($times);

                                        $in = $times[0]; // first time
                                        $out = end($times); // last time

                                        // Time-based status check
                                        $status = '';
                                        if ($in <= '10:00:00' && $out >= '16:00:00') {
                                            $status = '<span class="badge bg-success">P</span>';
                                        } elseif ($in > '10:00:00' && $out >= '16:00:00') {
                                            $status = '<span class="badge bg-warning text-dark">Late</span>';
                                        } elseif ($in <= '10:00:00' && $out < '16:00:00') {
                                            $status = '<span class="badge bg-info text-dark">Early Out</span>';
                                        } elseif ($in > '10:00:00' && $out < '16:00:00') {
                                            $status = '<span class="badge bg-danger">Late & Early Out</span>';
                                        } else {
                                            $status = '<span class="badge bg-secondary">—</span>';
                                        }

                                        $tooltip = "In: " . date('h:i A', strtotime($in)) . " | Out: " . date('h:i A', strtotime($out));
                                    } else {
                                        $status = '<span class="text-muted">-</span>';
                                        $tooltip = '';
                                    }
                                    ?>
                                    <td title="<?= esc($tooltip) ?>"><?= $status ?></td>
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
</div>

<?= $this->include("layouts/base-structure/footer"); ?>
<?= $this->endSection(); ?>