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
                        <input type="month" name="month" class="form-control"
                            value="<?= esc($selectedMonth) ?>">
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
                    <span class="badge bg-info text-dark">E = Early Out</span>
                    <span class="badge bg-danger">H = Holiday</span>
                </div>

                <div class="table-responsive" style="max-height:600px;overflow:auto;">
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

                                        // Friday & Saturday Holiday
                                        if ($dayName == 'Fri' || $dayName == 'Sat') {
                                            echo "<td><span class='badge bg-danger'>H</span></td>";
                                            continue;
                                        }

                                        $totalDays++;

                                        $attendance = $attendanceMap[$t['id']][$date] ?? null;

                                        $status = 'A';
                                        $badge = 'bg-secondary';

                                        if ($attendance) {
                                            $status = $attendance['remark'];

                                            if ($status == 'Present') {
                                                $status = 'P';
                                                $badge = 'bg-success';
                                                $presentCount++;
                                            } elseif ($status == 'Absent') {
                                                $status = 'A';
                                                $badge = 'bg-secondary';
                                            } elseif ($status == 'Late') {
                                                $status = 'L';
                                                $badge = 'bg-warning text-dark';
                                            } elseif ($status == 'Leave') {
                                                $status = 'E';
                                                $badge = 'bg-info text-dark';
                                            }
                                        }
                                        ?>

                                        <td><span class="badge <?= $badge ?>"><?= $status ?></span></td>

                                    <?php endforeach; ?>

                                    <td><strong><?= $totalDays ?></strong></td>
                                    <td><strong><?= $presentCount ?></strong></td>
                                    <td><strong><?= round(($presentCount / $totalDays) * 100) ?>%</strong></td>
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