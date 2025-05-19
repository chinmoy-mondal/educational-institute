<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<!-- Registration Form -->
<div class="container content mb-5 pb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register</h3>

                    <!-- Error Flash Messages -->
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/register') ?>" method="post" id="registerForm">
                        <?= csrf_field() ?>
                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="<?= old('name') ?>" placeholder="Enter full name" required>
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select form-control-lg" id="role" name="role" required>
                                <option disabled <?= old('role') ? '' : 'selected' ?>>Select Role</option>
                                <option value="Teacher" <?= old('role') === 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                                <option value="Staff" <?= old('role') === 'Staff' ? 'selected' : '' ?>>Staff</option>
                            </select>
                        </div>

                        <!-- Designation -->
                        <div class="mb-3 <?= old('role') ? '' : 'd-none' ?>" id="designationGroup">
                            <label for="designation" class="form-label">Designation</label>
                            <select class="form-select form-control-lg" id="designation" name="designation">
                                <option disabled <?= old('designation') ? '' : 'selected' ?>>Select Designation</option>
                                <?php
                                $designations = [
                                    'Head Teacher', 'Asst. Head Teacher', 'Asst. Teacher','Trade Instructor','Trade assistant','3rd Classs Employee','4th  Class Employee','Officeassistant(mlss)','Security Guard','Cleaner','Ayah'
                                ];
                                foreach ($designations as $des) :
                                ?>
                                    <option <?= old('designation') === $des ? 'selected' : '' ?>><?= $des ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3 <?= old('role') === 'Teacher' ? '' : 'd-none' ?>" id="subjectGroup">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select form-control-lg" id="subject" name="subject">
                                <option disabled <?= old('subject') ? '' : 'selected' ?>>Select Subject</option>
                                <?php
                                $subjects = [
                                    'Bangla', 'English', 'Mathematics', 'Science', 'Physics', 'Chemistry', 'Biology',
                                    'ICT (Information and Communication Technology)', 'Bangladesh and Global Studies',
                                    'Religion', 'Physical Education and Health', 'History', 'Civics', 'Sociology',
                                    'Geography', 'Accounting', 'Finance', 'Agriculture', 'Food Processing & Preservation',
                                    'Library and Information Science', 'N/A'
                                ];
                                foreach ($subjects as $subj) :
                                ?>
                                    <option <?= old('subject') === $subj ? 'selected' : '' ?>><?= $subj ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-control-lg" id="gender" name="gender" required>
                                <option disabled <?= old('gender') ? '' : 'selected' ?>>Select Gender</option>
                                <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female</option>
                                <option value="Others" <?= old('gender') === 'Others' ? 'selected' : '' ?>>Others</option>
                            </select>
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" value="<?= old('phone') ?>" placeholder="Enter phone number" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" value="<?= old('email') ?>" placeholder="Enter email" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Create password" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" placeholder="Confirm password" required>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">Register</button>
                        </div>
                    </form>
                    <p class="text-center mt-3">Already have an account? <a href="<?= base_url('/login') ?>">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?= $this->include("structure/footer"); ?>

<!-- JS to Show/Hide Designation and Subject -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById("role");
        const designationGroup = document.getElementById("designationGroup");
        const subjectGroup = document.getElementById("subjectGroup");

        function toggleFields() {
            const selectedRole = roleSelect.value;
            if (selectedRole === "Teacher" || selectedRole === "Staff") {
                designationGroup.classList.remove("d-none");
            } else {
                designationGroup.classList.add("d-none");
            }

            if (selectedRole === "Teacher") {
                subjectGroup.classList.remove("d-none");
            } else {
                subjectGroup.classList.add("d-none");
            }
        }

        roleSelect.addEventListener("change", toggleFields);
        toggleFields(); // Run on page load in case old('role') is set
    });
</script>

<?= $this->endSection(); ?>
