<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Header -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<!-- Login Form -->
<div class="container content mb-5 pb-5"> <!-- Adds space at bottom -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg rounded">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Student Login</h3>
                    
                    <form action="#" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <p class="text-center mt-3">
                        Don't have an account? <a href="<?= base_url('register'); ?>">Register here</a><br>
                        <a href="#">Forgot password?</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>