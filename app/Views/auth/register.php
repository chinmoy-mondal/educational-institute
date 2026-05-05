<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">

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

                <form action="<?= base_url('/register') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="row g-3">

                        <!-- NAME -->
                        <div class="col-12">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control form-control-lg"
                                value="<?= old('name') ?>">
                        </div>

                        <!-- ROLE (CLINIC) -->
                        <div class="col-12">
                            <label class="form-label">Role</label>
                            <select class="form-select form-control-lg" id="role" name="role">
                                <option value="">Select Role</option>
                                <option value="Doctor">Doctor</option>
                                <option value="Nurse">Nurse</option>
                                <option value="Receptionist">Receptionist</option>
                                <option value="Lab Technician">Lab Technician</option>
                                <option value="Pharmacist">Pharmacist</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>

                        <!-- DESIGNATION -->
                        <div class="col-12 d-none" id="designationGroup">
                            <label class="form-label">Designation</label>
                            <select class="form-select form-control-lg" id="designation" name="designation"></select>
                        </div>

                        <!-- GENDER -->
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select form-control-lg" name="gender">
                                <option value="">Select</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Others</option>
                            </select>
                        </div>

                        <!-- PHONE -->
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-lg">
                        </div>

                        <!-- EMAIL -->
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg">
                        </div>

                        <!-- PASSWORD -->
                        <div class="col-md-6">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control form-control-lg">
                        </div>

                        <!-- CONFIRM -->
                        <div class="col-md-6">
                            <label class="form-label">Confirm</label>
                            <input type="password" name="confirm_password" class="form-control form-control-lg">
                        </div>

                        <!-- SUBMIT -->
                        <div class="col-12 mt-3">
                            <button class="btn btn-primary btn-lg w-100">
                                Create Account
                            </button>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {

        const role = document.getElementById("role");
        const designationGroup = document.getElementById("designationGroup");
        const designation = document.getElementById("designation");

        // Clinic designations
        const map = {
            "Doctor": ["Senior Doctor", "Junior Doctor", "Consultant"],
            "Nurse": ["Head Nurse", "Staff Nurse"],
            "Receptionist": ["Front Desk Officer"],
            "Lab Technician": ["Lab Assistant", "Senior Lab Tech"],
            "Pharmacist": ["Pharmacy Officer"],
            "Staff": ["Cleaner", "Assistant Staff"]
        };

        role.addEventListener("change", function() {

            let val = this.value;

            if (map[val]) {
                designationGroup.classList.remove("d-none");

                designation.innerHTML = "";

                map[val].forEach(item => {
                    let opt = document.createElement("option");
                    opt.value = item;
                    opt.textContent = item;
                    designation.appendChild(opt);
                });

            } else {
                designationGroup.classList.add("d-none");
                designation.innerHTML = "";
            }

        });

    });
</script>

<?= $this->endSection(); ?>