<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- LOGIN WRAPPER -->
<div class="container content d-flex align-items-center justify-content-center" style="min-height:80vh;">

    <div class="row w-100 justify-content-center">

        <div class="col-md-5 col-lg-4">

            <!-- CARD -->
            <div class="card p-4 shadow-sm border-0">

                <!-- HEADER -->
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">Welcome Back</h3>
                    <p class="text-muted">Login to Clinic Dashboard</p>
                </div>

                <!-- ERROR -->
                <?php if (session()->getFlashdata('error')) : ?>
                <div class="alert alert-danger">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
                <?php endif; ?>

                <form action="<?= base_url('/login') ?>" method="post">

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter email"
                            value="<?= old('email') ?>">
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-2">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg"
                            placeholder="Enter password">
                    </div>

                    <!-- FORGOT -->
                    <div class="text-end mb-3">
                        <a href="<?= base_url('/forgot-password') ?>" class="small text-primary">
                            Forgot Password?
                        </a>
                    </div>

                    <!-- BUTTON -->
                    <button class="btn btn-primary btn-lg w-100">
                        Login
                    </button>

                </form>

                <!-- FOOT NOTE -->
                <div class="text-center mt-3">
                    <small>
                        Don’t have an account?
                        <a href="<?= base_url('/register') ?>">Create account</a>
                    </small>
                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>