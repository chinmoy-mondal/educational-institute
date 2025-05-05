<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<!-- Student Registration Form -->
<div class="container content mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Student Registration</h3>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                    <?php endif; ?>

                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/student/save" method="post" enctype="multipart/form-data" class="row g-3">
                        <?= csrf_field() ?>

                        <div class="col-md-6">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="student_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <input type="text" name="class" class="form-control" required>
                        </div>
                       <div class="col-md-6">
                            <label class="form-label">Section</label>
                            <select name="section" class="form-select" required>
                                <option value="">Select Section</option>
                                <option value="General - Science">General → Science</option>
                                <option value="General - Arts">General → Arts</option>
                                <option value="Vocational - Food Processing and Preservation">Vocational → Food Processing and Preservation</option>
                                <option value="Vocational - IT Support and IoT Basics">Vocational → IT Support and IoT Basics</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ESIF</label>
                            <input type="text" name="esif" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student Picture</label>
                            <input type="file" name="student_pic" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Student Birth Registration Card</label>
                            <input type="file" name="birth_registration_pic" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Father's ID Card</label>
                            <input type="file" name="father_id_pic" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mother's ID Card</label>
                            <input type="file" name="mother_id_pic" class="form-control" required>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                            <a href="/student/list" class="btn btn-secondary">View All Students</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer Include -->
<?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>
