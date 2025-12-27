<table border="1" cellspacing="0" cellpadding="5">
    <!-- First header row -->
    <tr>
        <th rowspan="2">Subject</th>
        <th rowspan="2">Full Mark</th>
        <th colspan="4">Half Yearly</th>
        <th colspan="4">Annual</th>
        <th rowspan="2">Total</th>
        <th rowspan="2">%</th>
        <th rowspan="2">Grade</th>
        <th rowspan="2">GP</th>
    </tr>

    <!-- Second header row -->
    <tr>
        <th>W</th>
        <th>M</th>
        <th>P</th>
        <th>T</th>
        <th>W</th>
        <th>M</th>
        <th>P</th>
        <th>T</th>
    </tr>

    <?php foreach ($marksheet as $id => $row): ?>
    <tr>
        <td><?= $row['subject'] ?></td>
        <td><?= $row['full_mark'] ?></td>

        <!-- Half Yearly -->
        <td><?= $row['half_written'] ?></td>
        <td><?= $row['half_mcq'] ?></td>
        <td><?= $row['half_prac'] ?></td>
        <td><?= $row['half_total'] ?></td>

        <!-- Annual -->
        <td><?= $row['annual_written'] ?></td>
        <td><?= $row['annual_mcq'] ?></td>
        <td><?= $row['annual_prac'] ?></td>
        <td><?= $row['annual_total'] ?></td>

        <?php
            // First 2 pairs: rowspan
            if ($id < 4 && $id % 2 == 0): ?>
        <td rowspan="2"><?= $row['total'] ?></td>
        <td rowspan="2"><?= $row['percentage'] ?>%</td>
        <td rowspan="2"><?= $row['grade'] ?></td>
        <td rowspan="2"><?= $row['gp'] ?></td>
        <?php elseif ($id >= 4): ?>
        <td><?= $row['total'] ?></td>
        <td><?= $row['percentage'] ?>%</td>
        <td><?= $row['grade'] ?></td>
        <td><?= $row['gp'] ?></td>
        <?php endif; ?>
    </tr>
    <?php endforeach; ?>
</table>