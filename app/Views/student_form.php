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
                            <input type="text" name="student_name" class="form-control" value="<?= old('student_name') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" value="<?= old('roll') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="">Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('class') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-6" id="section-container" style="display: none;">
                            <label class="form-label">Section (Only for Class 9 & 10)</label>
                            <select name="section" class="form-select">
                                <option value="">Select Section</option>
                                <option value="General - Science" <?= old('section') == 'General - Science' ? 'selected' : '' ?>>General → Science</option>
                                <option value="General - Arts" <?= old('section') == 'General - Arts' ? 'selected' : '' ?>>General → Arts</option>
                                <option value="Vocational - Food Processing and Preservation" <?= old('section') == 'Vocational - Food Processing and Preservation' ? 'selected' : '' ?>>Vocational → Food Processing and Preservation</option>
                                <option value="Vocational - IT Support and IoT Basics" <?= old('section') == 'Vocational - IT Support and IoT Basics' ? 'selected' : '' ?>>Vocational → IT Support and IoT Basics</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Board id</label>
                            <input type="text" name="esif" class="form-control" value="<?= old('esif') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= old('dob') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Student Picture</label>
                            <input type="file" name="student_pic" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Birth Registration Number</label>
                            <input type="text" name="birth_registration_number" class="form-control" value="<?= old('birth_registration_number') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" class="form-control" value="<?= old('father_nid_number') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" class="form-control" value="<?= old('mother_nid_number') ?>" required>
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

<?= $this->include("structure/footer"); ?>

<script>
    function toggleSectionField() {
        const classSelect = document.getElementById('class-select');
        const sectionContainer = document.getElementById('section-container');
        const selectedClass = classSelect.value;

        if (selectedClass === '9' || selectedClass === '10') {
            sectionContainer.style.display = 'block';
        } else {
            sectionContainer.style.display = 'none';
        }
    }

    document.getElementById('class-select').addEventListener('change', toggleSectionField);
    window.addEventListener('DOMContentLoaded', toggleSectionField);
</script>

<?= $this->endSection(); ?>
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
                            <input type="text" name="student_name" class="form-control" value="<?= old('student_name') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" value="<?= old('roll') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="">Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('class') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-6" id="section-container" style="display: none;">
                            <label class="form-label">Section (Only for Class 9 & 10)</label>
                            <select name="section" class="form-select">
                                <option value="">Select Section</option>
                                <option value="General - Science" <?= old('section') == 'General - Science' ? 'selected' : '' ?>>General → Science</option>
                                <option value="General - Arts" <?= old('section') == 'General - Arts' ? 'selected' : '' ?>>General → Arts</option>
                                <option value="Vocational - Food Processing and Preservation" <?= old('section') == 'Vocational - Food Processing and Preservation' ? 'selected' : '' ?>>Vocational → Food Processing and Preservation</option>
                                <option value="Vocational - IT Support and IoT Basics" <?= old('section') == 'Vocational - IT Support and IoT Basics' ? 'selected' : '' ?>>Vocational → IT Support and IoT Basics</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Board id</label>
                            <input type="text" name="esif" class="form-control" value="<?= old('esif') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= old('dob') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Student Picture</label>
                            <input type="file" name="student_pic" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Birth Registration Number</label>
                            <input type="text" name="birth_registration_number" class="form-control" value="<?= old('birth_registration_number') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" class="form-control" value="<?= old('father_nid_number') ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" class="form-control" value="<?= old('mother_nid_number') ?>" required>
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

<?= $this->include("structure/footer"); ?>

<script>
    function toggleSectionField() {
        const classSelect = document.getElementById('class-select');
        const sectionContainer = document.getElementById('section-container');
        const selectedClass = classSelect.value;

        if (selectedClass === '9' || selectedClass === '10') {
            sectionContainer.style.display = 'block';
        } else {
            sectionContainer.style.display = 'none';
        }
    }

    document.getElementById('class-select').addEventListener('change', toggleSectionField);
    window.addEventListener('DOMContentLoaded', toggleSectionField);
</script>

<?= $this->endSection(); ?>
