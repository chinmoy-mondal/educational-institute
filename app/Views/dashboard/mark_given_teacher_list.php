<tbody>
<?php if (!empty($teachers)): ?>
    <?php $sn = 1; ?>
    <?php foreach ($teachers as $t): ?>
        <?php $teacher = $t['teacher']; ?>
        <?php foreach ($t['subjects'] as $sub): ?>
            <tr class="text-center">
                <td><?= $sn++ ?></td>

                <td><?= esc($sub['class']) ?></td>
                <td><?= esc($sub['subject_name']) ?> (<?= esc($sub['exam']) ?>)</td>

                <td>
                    <img src="<?= !empty($teacher['picture']) ? $teacher['picture'] : base_url('public/assets/img/default.png') ?>"
                         width="50" height="50" class="rounded-circle">
                </td>

                <td class="text-start"><?= esc($teacher['name']) ?></td>

                <td>
                    <small>
                        Students: <b><?= $sub['total_students'] ?></b> |
                        Marks Entered: <b><?= $sub['marks_entered'] ?></b>
                    </small>

                    <div class="progress mt-1" style="height: 20px;">
                        <div class="progress-bar bg-success"
                             style="width: <?= $sub['progress'] ?>%;">
                            <?= $sub['progress'] ?>%
                        </div>
                    </div>
                </td>

                <td>
                    <a href="<?= site_url('profile_id/' . $teacher['id']) ?>"
                       class="btn btn-sm btn-info me-1">
                        <i class="fas fa-user"></i>
                    </a>

                    <a href="tel:<?= esc($teacher['phone']) ?>"
                       class="btn btn-sm btn-success me-1">
                        <i class="fas fa-phone"></i>
                    </a>

                    <a href="<?= site_url('teacher_result/' . $teacher['id']) ?>"
                       class="btn btn-sm btn-warning">
                        <i class="fas fa-chart-bar"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>

<?php else: ?>
    <tr>
        <td colspan="7" class="text-center text-muted">No teacher or subject data found.</td>
    </tr>
<?php endif; ?>
</tbody>