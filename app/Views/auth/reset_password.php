<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h3 class="text-center mb-4">Reset Password</h3>

                    <form method="post" action="<?= base_url('/reset-password/update') ?>">
                        <input type="hidden" name="token" value="<?= esc($token) ?>">

                        <div class="mb-3">
                            <label>New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirm" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>