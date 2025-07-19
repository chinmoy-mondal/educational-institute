<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h4 class="mb-4">Student Results</h4>

    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Exam</th>
                    <th>Year</th>
                    <th>Total Marks</th>
                    <th>Updated At</th>
                    <!-- Optional Action -->
                    <!-- <th>Action</th> -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $i => $r): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($r['student_name'] ?? 'Unknown') ?></td>
                            <td><?= esc($r['subject_name'] ?? 'Unknown') ?></td>
                            <td><?= esc($r['exam']) ?></td>
                            <td><?= esc($r['year']) ?></td>
                            <td><?= esc($r['total']) ?></td>
                            <td><?= esc($r['updated_at']) ?: '-' ?></td>
                            <!-- Optional Action -->
                            <!--
                            <td>
                                <a href="<?= site_url('results/edit/' . $r['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                            -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-muted">No results found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
