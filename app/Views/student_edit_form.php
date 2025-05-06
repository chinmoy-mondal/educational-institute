<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<div class="container content mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Edit Student</h3>

                    <form action="/student/update/<?= $student['id'] ?>" method="post" enctype="multipart/form-data" class="row g-3">
                        <?= csrf_field() ?>
                        <div class="col-md-6">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="student_name" class="form-control" value="<?= esc($student['student_name']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" value="<?= esc($student['roll']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="">Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= (isset($student['class']) && $student['class'] == $i) ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
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
                            <input type="text" name="esif" class="form-control" value="<?= esc($student['esif']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= esc($student['dob']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($student['phone']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Student Picture (leave empty to keep existing)</label>
                            <?php if (!empty($student['student_pic'])): ?>
                                <div class="mb-2">
                                    <img src="/<?= esc($student['student_pic']) ?>" class="img-thumbnail" width="100">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="student_pic" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Birth Registration Number</label>
                            <input type="text" name="birth_registration_number" class="form-control" value="<?= esc($student['birth_registration_number']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" class="form-control" value="<?= esc($student['father_nid_number']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" class="form-control" value="<?= esc($student['mother_nid_number']) ?>">
                        </div>


                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary px-5">Update</button>
                            <a href="/student/list" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include("structure/footer"); ?>
<?= $this->endSection(); ?>
