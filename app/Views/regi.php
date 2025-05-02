<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="container content">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Student Registration</h2>
            <form action="<?= base_url('register/submit') ?>" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name:</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="class" class="form-label">Class:</label>
                    <select name="class" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth:</label>
                    <input type="date" name="dob" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="guardian" class="form-label">Guardian Name:</label>
                    <input type="text" name="guardian" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label">Contact Number:</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-light-custom">Register</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>