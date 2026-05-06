<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- CENTER WRAPPER -->
<div class="container content d-flex align-items-center justify-content-center" style="min-height:80vh;">

    <div class="row w-100 justify-content-center">

        <div class="col-md-5 col-lg-4" style="margin-top: 20px;">

            <!-- CARD -->
            <div class="card p-4 shadow-sm border-0">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Reset Password</h3>
                    <p class="text-muted">Create a new secure password</p>
                </div>

                <form method="post" action="<?= base_url('/reset-password/update') ?>">

                    <input type="hidden" name="token" value="<?= esc($token) ?>">

                    <!-- NEW PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control form-control-lg"
                            placeholder="Enter new password" required>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirm" class="form-control form-control-lg"
                            placeholder="Confirm password" required>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Update Password
                    </button>

                </form>

                <!-- BACK -->
                <div class="text-center mt-3">
                    <a href="<?= base_url('/login') ?>" class="small text-primary">
                        Back to Login
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>