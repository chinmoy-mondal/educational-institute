<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
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
                            <input type="text" name="student_name" class="form-control" value="<?= esc($student['student_name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Roll</label>
                            <input type="text" name="roll" class="form-control" value="<?= esc($student['roll']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Class</label>
                            <select name="class" id="class-select" class="form-select" required>
                                <option value="">Select Class</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= $student['class'] == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-6" id="section-container" style="display: none;">
                            <label class="form-label">Section (Only for Class 9 & 10)</label>
                            <select name="section" class="form-select">
                                <option value="">Select Section (Optional)</option>
                                <option value="General - Science" <?= $student['section'] == 'General - Science' ? 'selected' : '' ?>>General → Science</option>
                                <option value="General - Arts" <?= $student['section'] == 'General - Arts' ? 'selected' : '' ?>>General → Arts</option>
                                <option value="Vocational - Food Processing and Preservation" <?= $student['section'] == 'Vocational - Food Processing and Preservation' ? 'selected' : '' ?>>Vocational → Food Processing and Preservation</option>
                                <option value="Vocational - IT Support and IoT Basics" <?= $student['section'] == 'Vocational - IT Support and IoT Basics' ? 'selected' : '' ?>>Vocational → IT Support and IoT Basics</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Board id</label>
                            <input type="text" name="esif" class="form-control" value="<?= esc($student['esif']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father's Name</label>
                            <input type="text" name="father_name" class="form-control" value="<?= esc($student['father_name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="mother_name" class="form-control" value="<?= esc($student['mother_name']) ?>" required>
                        </div>                        

                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" class="form-control" value="<?= esc($student['dob']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male" <?= $student['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= $student['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Other" <?= $student['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?= esc($student['phone']) ?>" required>
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
                            <input type="text" name="birth_registration_number" class="form-control" value="<?= esc($student['birth_registration_number']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Father NID Number</label>
                            <input type="text" name="father_nid_number" class="form-control" value="<?= esc($student['father_nid_number']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mother NID Number</label>
                            <input type="text" name="mother_nid_number" class="form-control" value="<?= esc($student['mother_nid_number']) ?>" required>
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

<?= $this->include("layouts/base-structure/footer"); ?>

<!-- JavaScript to toggle section field -->
<script>
    function toggleSectionField() {
        const classSelect = document.getElementById('class-select');
        const sectionContainer = document.getElementById('section-container');
        const selectedClass = classSelect.value;

        if (selectedClass === '9' || selectedClass === '10') {
            sectionContainer.style.display = 'block';
        } else {
            sectionContainer.style.display = 'none';
            const sectionSelect = sectionContainer.querySelector('select');
            if (sectionSelect) sectionSelect.value = '';
        }
    }

    document.getElementById('class-select').addEventListener('change', toggleSectionField);
    window.addEventListener('DOMContentLoaded', toggleSectionField);
</script>

<?= $this->endSection(); ?>
