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

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="mb-3 text-end">
                        <a href="/student" class="btn btn-success">+ Add New Student</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student Pic</th>
                                    <th>Name</th>
                                    <th>Roll</th>
                                    <th>Class</th>
                                    <th>Section</th>
                                    <th>ESIF</th>
                                    <th>DOB</th>
                                    <th>Phone</th>
                                    <th>Birth Reg. No</th>
                                    <th>Father NID</th>
                                    <th>Mother NID</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <?php if ($student['student_pic']): ?>
                                                    <img src="/<?= esc($student['student_pic']) ?>" class="img-thumbnail" width="80">
                                                <?php endif; ?>
                                            </td>
                                            <td><?= esc($student['student_name']) ?></td>
                                            <td><?= esc($student['roll']) ?></td>
                                            <td><?= esc($student['class']) ?></td>
                                            <td><?= esc($student['section']) ?></td>
                                            <td><?= esc($student['esif']) ?></td>
                                            <td><?= esc($student['dob']) ?></td>
                                            <td><?= esc($student['phone']) ?></td>
                                            <td><?= esc($student['birth_registration_number']) ?></td>
                                            <td><?= esc($student['father_nid_number']) ?></td>
                                            <td><?= esc($student['mother_nid_number']) ?></td>
                                            <td>
                                                <a href="/student/edit/<?= $student['id'] ?>" class="btn btn-sm btn-primary mb-1">Edit</a>
                                                <form action="/student/delete/<?= $student['id'] ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center">No students found.</td>
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
