<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

            <!-- 🌟 CARD -->
            <div class="card p-4 shadow-sm">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Create Account</h3>
                    <p class="text-muted">Clinic Management System Registration</p>
                </div>

                <!-- ERRORS -->
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

                    <div class="row g-3">

                        <!-- NAME -->
                        <div class="col-12">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                placeholder="Enter full name" value="<?= old('name') ?>">
                        </div>

                        <!-- ROLE -->
                        <div class="col-12">
                            <label class="form-label">Role</label>
                            <select class="form-select form-control-lg" id="role" name="role">
                                <option value="">Select Role</option>
                                <option value="Teacher" <?= old('role') === 'Teacher' ? 'selected' : '' ?>>Teacher
                                </option>
                                <option value="Staff" <?= old('role') === 'Staff' ? 'selected' : '' ?>>Staff</option>
                            </select>
                        </div>

                        <!-- DESIGNATION -->
                        <div class="col-12 d-none" id="designationGroup">
                            <label class="form-label">Designation</label>
                            <select class="form-select form-control-lg" id="designation" name="designation"></select>
                        </div>

                        <!-- SUBJECT -->
                        <div class="col-12 d-none" id="subjectGroup">
                            <label class="form-label">Subject</label>
                            <select class="form-select form-control-lg" name="subject">
                                <option value="">Select Subject</option>
                                <?php
                                $subjects = [
                                    'Bangla',
                                    'English',
                                    'Mathematics',
                                    'Science',
                                    'Physics',
                                    'Chemistry',
                                    'Biology',
                                    'ICT (Information and Communication Technology)',
                                    'Bangladesh and Global Studies',
                                    'Religion (Hinduism)',
                                    'Religion (Islam)',
                                    'Physical Education and Health',
                                    'History',
                                    'Civics',
                                    'Sociology',
                                    'Geography',
                                    'Accounting',
                                    'Finance',
                                    'Agriculture',
                                    'Food Processing & Preservation',
                                    'Library and Information Science',
                                    'N/A'
                                ];
                                foreach ($subjects as $subj):
                                ?>
                                    <option <?= old('subject') === $subj ? 'selected' : '' ?>><?= $subj ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- GENDER -->
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select form-control-lg" name="gender">
                                <option value="">Select</option>
                                <option value="Male" <?= old('gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                                <option value="Female" <?= old('gender') === 'Female' ? 'selected' : '' ?>>Female
                                </option>
                                <option value="Others" <?= old('gender') === 'Others' ? 'selected' : '' ?>>Others
                                </option>
                            </select>
                        </div>

                        <!-- PHONE -->
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-lg"
                                placeholder="Phone number" value="<?= old('phone') ?>">
                        </div>

                        <!-- EMAIL -->
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                placeholder="Email address" value="<?= old('email') ?>">
                        </div>

                        <!-- PASSWORD -->
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg"
                                placeholder="Password">
                        </div>

                        <!-- CONFIRM -->
                        <div class="col-md-6">
                            <label class="form-label">Confirm</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg"
                                placeholder="Confirm password">
                        </div>

                        <!-- SUBMIT -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary btn-lg w-100">
                                Register Account
                            </button>
                        </div>

                    </div>
                </form>

                <!-- LOGIN -->
                <div class="text-center mt-3">
                    <small>Already have account? <a href="<?= base_url('/login') ?>">Login</a></small>
                </div>

            </div>

        </div>
    </div>

</div>

<!-- JS -->
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const role = document.getElementById("role");
        const designationGroup = document.getElementById("designationGroup");
        const designation = document.getElementById("designation");
        const subjectGroup = document.getElementById("subjectGroup");

        const teacher = ['Head Teacher', 'Asst. Head Teacher', 'Asst. Teacher', 'Trade Instructor'];
        const staff = ['Trade Assistant', 'Office Assistant', 'Security Guard', 'Cleaner'];

        role.addEventListener("change", function() {

            designationGroup.classList.remove("d-none");

            let list = [];

            if (this.value === "Teacher") {
                list = teacher;
                subjectGroup.classList.remove("d-none");
            } else {
                list = staff;
                subjectGroup.classList.add("d-none");
            }

            designation.innerHTML = "";

            list.forEach(item => {
                let opt = document.createElement("option");
                opt.value = item;
                opt.textContent = item;
                designation.appendChild(opt);
            });

        });

    });
</script>

<?= $this->endSection(); ?>