<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- EXAM ROUTINE LIST -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Exam Routine List</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($events as $e): ?>
                    <tr>

                        <td><?= $e['id'] ?></td>

                        <!-- CLASS -->
                        <td>Class <?= $e['class'] ?></td>

                        <!-- SUBJECT -->
                        <td>
                            <?php
                                $subjectName = '';
                                foreach ($subjects as $sub) {
                                    if ($sub['id'] == $e['subject']) {
                                        $subjectName = $sub['subject'];
                                        break;
                                    }
                                }
                                echo $subjectName;
                                ?>
                        </td>

                        <!-- DATE -->
                        <td><?= date('d M Y', strtotime($e['start_date'])) ?></td>

                        <!-- TIME -->
                        <td>
                            <?= date('h:i A', strtotime($e['start_time'])) ?>
                            -
                            <?= date('h:i A', strtotime($e['end_time'])) ?>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>