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
                    <form action="<?= base_url('/register') ?>" method="post" id="registerForm">

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" placeholder="Enter full name" required>
                        </div>

                        <!-- Role Selection -->
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select form-control-lg" id="role" name="role" required>
                                <option selected disabled>Select Role</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>

                        <!-- Designation -->
                        <div class="mb-3 d-none" id="designationGroup">
                            <label for="designation" class="form-label">Designation</label>
                            <select class="form-select form-control-lg" id="designation" name="designation">
                                <option selected disabled>Select Designation</option>
                                <option>Head Sir</option>
                                <option>Senior Teacher</option>
                                <option>Assistant Teacher</option>
                                <option>Junior Teacher</option>
                                <option>Lab Assistant</option>
                                <option>Clerk</option>
                                <option>Librarian</option>
                                <option>Peon</option>
                                <option>Cleaner</option>
                            </select>
                        </div>

                        <!-- Subject -->
                        <div class="mb-3 d-none" id="subjectGroup">
                            <label for="subject" class="form-label">Subject</label>
                            <select class="form-select form-control-lg" id="subject" name="subject">
                                <option selected disabled>Select Subject</option>
                                <option>Mathematics</option>
                                <option>English</option>
                                <option>Science</option>
                                <option>Biology</option>
                                <option>Physics</option>
                                <option>Chemistry</option>
                                <option>Social Studies</option>
                                <option>Geography</option>
                                <option>History</option>
                                <option>Computer Science</option>
                                <option>Physical Education</option>
                                <option>Art</option>
                                <option>Music</option>
                                <option>Hindi</option>
                                <option>Bengali</option>
                                <option>Urdu</option>
                                <option>Islamic Studies</option>
                                <option>Moral Science</option>
                                <option>Environmental Studies</option>
                            </select>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" placeholder="Enter phone number" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control form-control-lg" id="email" name="email" placeholder="Enter email" required>
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

                        <!-- Submit Button -->
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

<!-- JS to Handle Role Selection -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const roleSelect = document.getElementById("role");
        const designationGroup = document.getElementById("designationGroup");
        const subjectGroup = document.getElementById("subjectGroup");

        roleSelect.addEventListener("change", function () {
            const selectedRole = this.value;

            // Show designation for all staff/teachers/admin
            if (selectedRole === "Teacher" || selectedRole === "Staff") {
                designationGroup.classList.remove("d-none");
            } else {
                designationGroup.classList.add("d-none");
            }

            // Show subject field only for teachers
            if (selectedRole === "Teacher") {
                subjectGroup.classList.remove("d-none");
            } else {
                subjectGroup.classList.add("d-none");
            }
        });
    });
</script>

<?= $this->endSection(); ?>