<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <h2 class="card-title text-center mb-4 fw-bold text-primary">Student Registration</h2>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

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

                    <form action="/student/save" method="post" enctype="multipart/form-data" class="row g-3 needs-validation" novalidate>
                        <?= csrf_field() ?>

                        <div class="col-12 col-md-6">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control" value="<?= old('student_name') ?>" required>
                            <div class="invalid-feedback">Please enter student name.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="roll" class="form-label">Roll</label>
                            <input type="text" name="roll" id="roll" class="form-control" value="<?= old('roll') ?>" required>
                            <div class="invalid-feedback">Please enter roll number.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="class-select" class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="" disabled <?= old('class') ? '' : 'selected' ?>>Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= old('class') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback">Please select a class.</div>
                        </div>

                        <div class="col-12 col-md-6" id="section-container" style="display: none;">
                            <label for="section" class="form-label">Section (Only for Class 9 & 10)</label>
                            <select name="section" id="section" class="form-select">
                                <option value="" disabled <?= old('section') ? '' : 'selected' ?>>Select Section</option>
                                <option value="General - Science" <?= old('section') == 'General - Science' ? 'selected' : '' ?>>General → Science</option>
                                <option value="General - Arts" <?= old('section') == 'General - Arts' ? 'selected' : '' ?>>General → Arts</option>
                                <option value="Vocational - Food Processing and Preservation" <?= old('section') == 'Vocational - Food Processing and Preservation' ? 'selected' : '' ?>>Vocational → Food Processing and Preservation</option>
                                <option value="Vocational - IT Support and IoT Basics" <?= old('section') == 'Vocational - IT Support and IoT Basics' ? 'selected' : '' ?>>Vocational → IT Support and IoT Basics</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="esif" class="form-label">Board ID</label>
                            <input type="text" name="esif" id="esif" class="form-control" value="<?= old('esif') ?>" required>
                            <div class="invalid-feedback">Please enter board ID.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="father_name" class="form-label">Father's Name</label>
                            <input type="text" name="father_name" id="father_name" class="form-control" value="<?= old('father_name') ?>" required>
                            <div class="invalid-feedback">Please enter father's name.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="mother_name" class="form-label">Mother's Name</label>
                            <input type="text" name="mother_name" id="mother_name" class="form-control" value="<?= old('mother_name') ?>" required>
                            <div class="invalid-feedback">Please enter mother's name.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" name="dob" id="dob" class="form-control" value="<?= old('dob') ?>" required>
                            <div class="invalid-feedback">Please select date of birth.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="" disabled <?= old('gender') ? '' : 'selected' ?>>Select Gender</option>
                                <option value="Male" <?= old('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= old('gender') == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                            <div class="invalid-feedback">Please select gender.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?= old('phone') ?>" required>
                            <div class="invalid-feedback">Please enter phone number.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="student_pic" class="form-label">Student Picture</label>
                            <input type="file" name="student_pic" id="student_pic" class="form-control" required>
                            <div class="invalid-feedback">Please upload a picture.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="birth_registration_number" class="form-label">Birth Registration Number</label>
                            <input type="text" name="birth_registration_number" id="birth_registration_number" class="form-control" value="<?= old('birth_registration_number') ?>" required>
                            <div class="invalid-feedback">Please enter birth registration number.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="father_nid_number" class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" id="father_nid_number" class="form-control" value="<?= old('father_nid_number') ?>" required>
                            <div class="invalid-feedback">Please enter father's NID number.</div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="mother_nid_number" class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" id="mother_nid_number" class="form-control" value="<?= old('mother_nid_number') ?>" required>
                            <div class="invalid-feedback">Please enter mother's NID number.</div>
                        </div>

                        <div class="col-12 d-flex justify-content-center gap-3 mt-4">
                            <button type="submit" class="btn btn-primary px-5 fw-semibold">Submit</button>
                            <a href="/student/list" class="btn btn-outline-secondary px-4">View All Students</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include("layouts/base-structure/footer"); ?>

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

    // Bootstrap 5 custom validation
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

<?= $this->endSection(); ?>
