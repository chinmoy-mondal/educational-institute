<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
.marksheet-box {
    background: #fff;
    padding: 20px;
    border: 2px solid #000;
}

.marksheet-box h4 {
    text-align: center;
    font-weight: bold;
    margin-bottom: 15px;
}

.table-bordered th,
.table-bordered td {
    border: 1px solid #000 !important;
    text-align: center;
    vertical-align: middle;
    padding: 6px;
}

thead th {
    background: #eee;
}

.table-danger {
    background-color: #f8d7da !important;
}

@media print {
    .no-print {
        display: none !important;
    }
}
</style>

<div class="container-fluid">
    <div class="marksheet-box">

        <h4>Academic Marksheet</h4>

        <!-- Student Info -->
        <?php if (isset($student)): ?>
        <div class="mb-3">
            <strong>Name:</strong> <?= esc($student['name'] ?? '') ?> |
            <strong>Class:</strong> <?= esc($student['class'] ?? '') ?> |
            <strong>Roll:</strong> <?= esc($student['roll'] ?? '') ?> |
            <strong>Year:</strong> <?= esc($year ?? '') ?>
        </div>
        <?php endif; ?>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Subject</th>
                    <th rowspan="2">Full Mark</th>
                    <th colspan="4">Half-Yearly</th>
                    <th colspan="4">Annual</th>
                    <th colspan="4">Average</th>
                    <th rowspan="2">Total</th>
                    <th rowspan="2">%</th>
                    <th rowspan="2">Grade</th>
                    <th rowspan="2">GP</th>
                </tr>
                <tr>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                    <th>W</th>
                    <th>M</th>
                    <th>P</th>
                    <th>T</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($marksheet as $row): ?>
                <?php
                    // Half-Yearly
                    $halfW = $row['half']['written'] ?? 0;
                    $halfM = $row['half']['mcq'] ?? 0;
                    $halfP = $row['half']['practical'] ?? 0;
                    $halfT = $halfW + $halfM + $halfP;

                    // Annual
                    $annW = $row['annual']['written'] ?? 0;
                    $annM = $row['annual']['mcq'] ?? 0;
                    $annP = $row['annual']['practical'] ?? 0;
                    $annT = $annW + $annM + $annP;

                    // Average
                    $avgW = $row['average']['written'] ?? round(($halfW + $annW) / 2, 2);
                    $avgM = $row['average']['mcq'] ?? round(($halfM + $annM) / 2, 2);
                    $avgP = $row['average']['practical'] ?? round(($halfP + $annP) / 2, 2);
                    $avgT = $row['average']['total'] ?? round($avgW + $avgM + $avgP, 2);

                    // Final
                    $finalTotal = $row['final']['total'] ?? $avgT;
                    $percentage = $row['final']['percentage'] ?? ($row['full_mark'] > 0 ? round(($finalTotal / $row['full_mark']) * 100, 2) : 0);
                    $grade      = $row['final']['grade'] ?? '-';
                    $gp         = $row['final']['grade_point'] ?? '-';
                    $passStatus = $row['final']['pass_status'] ?? 'Pass';

                    // Optional subject mark
                    $subjectName = esc($row['subject']);
                    if (isset($row['half']['optional']) || isset($row['annual']['optional'])) {
                        $subjectName .= ' *';
                    }

                    // Row class for fail
                    $rowClass = ($passStatus === 'Fail') ? 'table-danger' : '';
                    ?>
                <tr class="<?= $rowClass ?>">
                    <td><?= $subjectName ?></td>
                    <td><?= esc($row['full_mark']) ?></td>

                    <!-- Half-Yearly -->
                    <td><?= $halfW ?></td>
                    <td><?= $halfM ?></td>
                    <td><?= $halfP ?></td>
                    <td><?= $halfT ?></td>

                    <!-- Annual -->
                    <td><?= $annW ?></td>
                    <td><?= $annM ?></td>
                    <td><?= $annP ?></td>
                    <td><?= $annT ?></td>

                    <!-- Average -->
                    <td><?= $avgW ?></td>
                    <td><?= $avgM ?></td>
                    <td><?= $avgP ?></td>
                    <td><?= $avgT ?></td>

                    <!-- Final -->
                    <td><?= $finalTotal ?></td>
                    <td><?= $percentage ?>%</td>
                    <td><?= $grade ?></td>
                    <td><?= $gp ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Print
            </button>
        </div>

    </div>
</div>

<?= $this->endSection() ?>