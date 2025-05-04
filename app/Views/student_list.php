<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<!-- Student List Table -->
<div class="container content mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Registered Students</h3>

                    <a href="/student" class="btn btn-success mb-3">Add New Student</a>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Name</th>
                                    <th>Roll</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>ESIF</th>
                                    <th>DOB</th>
                                    <th>Phone</th>
                                    <th>Birth Reg.</th>
                                    <th>Father ID</th>
                                    <th>Mother ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?= esc($student['student_name']) ?></td>
                                            <td><?= esc($student['roll']) ?></td>
                                            <td><?= esc($student['class']) ?></td>
                                            <td><?= esc($student['section']) ?></td>
                                            <td><?= esc($student['esif']) ?></td>
                                            <td><?= esc($student['dob']) ?></td>
                                            <td><?= esc($student['phone']) ?></td>
                                            <td><img src="/<?= esc($student['birth_registration_pic']) ?>" class="img-thumbnail" width="80"></td>
                                            <td><img src="/<?= esc($student['father_id_pic']) ?>" class="img-thumbnail" width="80"></td>
                                            <td><img src="/<?= esc($student['mother_id_pic']) ?>" class="img-thumbnail" width="80"></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No students found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Include -->
<?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>
