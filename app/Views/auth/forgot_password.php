<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- CENTER WRAPPER -->
<div class="container content d-flex align-items-center justify-content-center" style="min-height:80vh;">

    <div class="row w-100 justify-content-center">

        <div class="col-md-5 col-lg-4">

            <!-- CARD -->
            <div class="card p-4 shadow-sm border-0">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Forgot Password</h3>
                    <p class="text-muted">We will send reset link to your email</p>
                </div>

                <!-- SUCCESS / ERROR -->
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
                <?php endif; ?>

                <form method="post" action="<?= base_url('/forgot-password/send') ?>">

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg"
                            placeholder="Enter your email" required>
                    </div>

                    <!-- BUTTON -->
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        Send Reset Link
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