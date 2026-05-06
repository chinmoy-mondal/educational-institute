<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="container content">

    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8" style="margin-top: 20px;">

            <div class="card p-4 shadow-sm border-0">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Create Account</h3>
                    <p class="text-muted">Clinic Management System</p>
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
                                value="<?= old('name') ?>" placeholder="Enter full name">
                        </div>

                        <!-- ROLE (ONLY ADMIN TYPES) -->
                        <div class="col-12">
                            <label class="form-label">Account Type</label>
                            <select class="form-select form-control-lg" name="role" required>
                                <option value="">Select Account Type</option>
                                <option value="Super Admin" <?= old('role') === 'Super Admin' ? 'selected' : '' ?>>
                                    Super Admin
                                </option>
                                <option value="Admin" <?= old('role') === 'Admin' ? 'selected' : '' ?>>
                                    Admin
                                </option>
                            </select>
                        </div>

                        <!-- GENDER -->
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <select class="form-select form-control-lg" name="gender">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Others">Others</option>
                            </select>
                        </div>

                        <!-- PHONE -->
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-lg"
                                placeholder="Phone number">
                        </div>

                        <!-- EMAIL -->
                        <div class="col-12">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-lg"
                                placeholder="Email address">
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
                                Create Account
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

<?= $this->endSection(); ?>