<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-user-tie"></i> Teacher Attendance Report</h3>
            </div>

            <div class="card-body">

                <!-- Filter Form -->
                <form method="get" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <select name="teacher" class="form-control">
                            <option value="">All Teachers</option>
                            <?php foreach ($allTeachers as $t): ?>
                                <option value="<?= $t['id'] ?>" <?= ($selectedTeacher == $t['id']) ? 'selected' : '' ?>>
                                    <?= esc($t['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="month" name="month" class="form-control" value="<?= esc($selectedMonth) ?>">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary btn-block">Show</button>
                    </div>
                </form>

                <!-- Legend -->
                <div class="mb-3">
                    <span class="badge bg-success">P = Present</span>
                    <span class="badge bg-secondary">A = Absent</span>
                    <span class="badge bg-warning text-dark">L = Late</span>
                    <span class="badge bg-info text-dark">E = Leave</span>
                    <span class="badge bg-primary">L/E = Late/Early</span>
                    <span class="badge bg-danger">H = Holiday</span>
                </div>

                <!-- Attendance Table -->
                <div class="table-responsive" style="max-height:600px; overflow:auto;">
                    <table class="table table-bordered text-center small">
                        <thead class="table-dark">
                            <tr>
                                <th>Teacher Name</th>
                                <?php foreach ($daysInMonth as $day): ?>
                                    <th title="<?= $day['date'] ?>">
                                        <?= $day['day'] ?><br>
                                        <?= date('d', strtotime($day['date'])) ?>
                                    </th>
                                <?php endforeach; ?>
                                <th>Total Days</th>
                                <th>Present</th>
                                <th>%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($teachers as $t): ?>
                                <?php
                                $presentCount = 0;
                                $totalDays = 0;
                                ?>
                                <tr>
                                    <td class="text-left"><?= esc($t['name']) ?></td>
                                    <?php foreach ($daysInMonth as $day): ?>
                                        <?php
                                        $date = $day['date'];
                                        $dayName = $day['day'];
                                        $attendance = $attendanceMap[$t['id']][$date] ?? null;

                                        // Holiday on Fri/Sat
                                        if ($dayName === 'Fri' || $dayName === 'Sat') {
                                            $status = 'H';
                                            $tooltip = 'Holiday';
                                        } else {
                                            $status = $attendance['remark'] ?? 'A';
                                            $tooltip = '';

                                            // Calculate L/E if both arrival and leave exist
                                            $arrivalSec = isset($attendance['arrival']) ? strtotime($date . ' ' . $attendance['arrival']) : null;
                                            $leaveSec   = isset($attendance['leave']) ? strtotime($date . ' ' . $attendance['leave']) : null;
                                            $tenAM  = strtotime($date . ' 10:00:00');
                                            $fourPM = strtotime($date . ' 16:00:00');

                                            if ($arrivalSec && $leaveSec) {
                                                if ($arrivalSec > $tenAM && $leaveSec < $fourPM) {
                                                    $status = 'L/E';
                                                    $tooltip = 'Late/Early';
                                                }
                                            }
                                        }

                                        if ($status !== 'H') $totalDays++;
                                        if ($status === 'P') $presentCount++;

                                        $badge = match ($status) {
                                            'P' => 'bg-success',
                                            'A' => 'bg-secondary',
                                            'L' => 'bg-warning text-dark',
                                            'E' => 'bg-info text-dark',
                                            'L/E' => 'bg-primary',
                                            'H' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                        ?>
                                        <td><span class="badge <?= $badge ?>" title="<?= esc($tooltip) ?>"><?= $status ?></span></td>
                                    <?php endforeach; ?>
                                    <td><strong><?= $totalDays ?></strong></td>
                                    <td><strong><?= $presentCount ?></strong></td>
                                    <td><strong><?= $totalDays ? round(($presentCount / $totalDays) * 100) : 0 ?>%</strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>