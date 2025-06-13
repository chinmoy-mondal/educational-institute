<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h4 class="mb-0">Update Your Profile</h4>
                </div>
                <div class="card-body p-4">
                    <form action="<?= base_url('/account/update-profile') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" value="<?= old('name', session('user_name')) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" class="form-control" name="role" value="<?= old('role', session('user_role')) ?>" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" name="designation" value="<?= old('designation', session('designation')) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" class="form-control" name="subject" value="<?= old('subject', session('subject')) ?>">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?= session('gender') == 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= session('gender') == 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Others" <?= session('gender') == 'Others' ? 'selected' : '' ?>>Others</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= old('phone', session('phone')) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email (read-only)</label>
                            <input type="email" class="form-control" value="<?= session('user_email') ?>" readonly>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success rounded-pill py-2">Update Profile</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted text-center small">
                    Last updated at: <?= session('updated_at') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
