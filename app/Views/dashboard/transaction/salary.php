<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h3 class="mb-3"><?= $title ?></h3>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Teacher</th>
                        <?php
                        $months = [
                            1 => 'Jan',
                            2 => 'Feb',
                            3 => 'Mar',
                            4 => 'Apr',
                            5 => 'May',
                            6 => 'Jun',
                            7 => 'Jul',
                            8 => 'Aug',
                            9 => 'Sep',
                            10 => 'Oct',
                            11 => 'Nov',
                            12 => 'Dec'
                        ];
                        foreach ($months as $m) {
                            echo "<th>$m</th>";
                        }
                        ?>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($salaryData as $teacher => $monthsData): ?>
                    <?php $teacherTotal = 0; ?>
                    <tr>
                        <td><?= esc($teacher) ?></td>
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                        <?php
                                $amount = $monthsData[$m] ?? 0;
                                $teacherTotal += $amount;
                                ?>
                        <td class="text-right"><?= number_format($amount, 2) ?></td>
                        <?php endfor; ?>
                        <td class="text-right font-weight-bold"><?= number_format($teacherTotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="bg-secondary text-white">
                    <tr>
                        <th>Total</th>
                        <?php
                        // Column totals
                        for ($m = 1; $m <= 12; $m++) {
                            $colTotal = 0;
                            foreach ($salaryData as $teacher => $monthsData) {
                                $colTotal += $monthsData[$m] ?? 0;
                            }
                            echo "<th class='text-right'>" . number_format($colTotal, 2) . "</th>";
                        }
                        // Grand total
                        $grandTotal = 0;
                        foreach ($salaryData as $teacher => $monthsData) {
                            $grandTotal += array_sum($monthsData);
                        }
                        echo "<th class='text-right'>" . number_format($grandTotal, 2) . "</th>";
                        ?>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>