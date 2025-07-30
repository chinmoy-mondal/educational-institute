<?= $this->extend("layouts/admin") ?>
<?= $this->section("content"); ?>

<!-- Content Wrapper -->
<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <h1>Student Registration</h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Card -->
            <div class="card shadow-lg rounded">
                <div class="card-body">

                    <!-- Success message -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Validation errors -->
                    <?php if (session('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form -->
                    <form action="/student/save" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="col-md-6">
                            <label class="form-label">Student Name</label>
                            <input type="text" name="student_name" class="form-control" value="<?= old('student_name') ?>" required>
                            <div class="invalid-feedback">Please enter student name.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" value="<?= old('roll') ?>" required>
                            <div class="invalid-feedback">Please enter roll number.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="">Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('class') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback">Please select class.</div>
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
                            <label class="form-label">Board ID</label>
                            <input type="text" name="esif" class="form-control" value="<?= old('esif') ?>" required>
                            <div class="invalid-feedback">Please enter board ID.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="<?= old('father_name') ?>" required>
                            <div class="invalid-feedback">Please enter father's name.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control" value="<?= old('mother_name') ?>" required>
                            <div class="invalid-feedback">Please enter mother's name.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= old('dob') ?>" required>
                            <div class="invalid-feedback">Please enter date of birth.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <div class="invalid-feedback">Please select gender.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>" required>
                            <div class="invalid-feedback">Please enter phone number.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Student Picture</label>
                            <input type="file" name="student_pic" class="form-control" required>
                            <div class="invalid-feedback">Please upload student picture.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Birth Registration Number</label>
                            <input type="text" name="birth_registration_number" class="form-control" value="<?= old('birth_registration_number') ?>" required>
                            <div class="invalid-feedback">Please enter birth registration number.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" class="form-control" value="<?= old('father_nid_number') ?>" required>
                            <div class="invalid-feedback">Please enter father NID number.</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" class="form-control" value="<?= old('mother_nid_number') ?>" required>
                            <div class="invalid-feedback">Please enter mother NID number.</div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary px-5">Submit</button>
                            <a href="/student/list" class="btn btn-secondary ms-3">View All Students</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </section>

</div>

<?= $this->section('scripts') ?>
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

    // Bootstrap 5 validation
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
<?= $this->endSection() ?>

<?= $this->endSection(); ?>
