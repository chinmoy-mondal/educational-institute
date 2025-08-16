<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <!-- Edit Profile Card -->
    <div class="card card-primary card-outline mb-4 p-3">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user-edit me-2"></i>Edit <?= esc($user['role']) ?> Info</h3>
        </div>
        <form action="<?= site_url('admin/user/update/' . $user['id']) ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="card-body">
                <div class="row">
                    <!-- Left: Profile Picture -->
                    <div class="col-md-3 text-center">
                        <div class="mb-3">
                            <img class="profile-user-img img-fluid mb-2"
                                src="<?= !empty($user['picture'])
                                            ? base_url($user['picture'])
                                            : base_url('public/assets/img/default-profile-pic.png'); ?>"
                                alt="Teacher Photo"
                                style="width:150px; height:200px; object-fit:cover; border-radius:4px;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><i class="fas fa-image me-2"></i>Profile Photo</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="photoInput" accept="image/*">
                                    <label class="custom-file-label" for="photoInput">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Form Fields -->
                    <div class="col-md-9">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-id-card me-2"></i>Index No.</label>
                                <input type="text" name="index_number" value="<?= esc($user['index_number']) ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-calendar-alt me-2"></i>DOB</label>
                                <input type="date" name="dob" value="<?= esc($user['dob']) ?>" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-user-clock me-2"></i>Joining Date</label>
                                <input type="date" name="joining_date" value="<?= esc($user['joining_date']) ?>" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-user-clock me-2"></i>MPO Date</label>
                                <input type="date" name="mpo_date" value="<?= esc($user['mpo_date']) ?>" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="fas fa-praying-hands me-2"></i>Religion</label>
                                <select name="religion" class="form-control" required>
                                    <option value="" disabled <?= empty($user['religion']) ? 'selected' : '' ?>>Select Religion</option>
                                    <option value="Islam" <?= $user['religion'] === 'Islam' ? 'selected' : '' ?>>Islam</option>
                                    <option value="Hinduism" <?= $user['religion'] === 'Hinduism' ? 'selected' : '' ?>>Hinduism</option>
                                    <option value="Christianity" <?= $user['religion'] === 'Christianity' ? 'selected' : '' ?>>Christianity</option>
                                    <option value="Buddhism" <?= $user['religion'] === 'Buddhism' ? 'selected' : '' ?>>Buddhism</option>
                                    <option value="Other" <?= $user['religion'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label"><i class="fas fa-align-left me-2"></i>Bio</label>
                                <textarea name="bio" class="form-control" rows="4" placeholder="Write something about the user..."><?= esc($user['bio']) ?></textarea>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="card-footer text-end">
                <button type="submit" class="btn btn-success"><i class="fas fa-save me-2"></i>Save Changes</button>
                <a href="<?= site_url('admin/students/profile/' . $user['id']) ?>" class="btn btn-secondary"><i class="fas fa-times me-2"></i>Cancel</a>
            </div>
        </form>
    </div>
</div>

<!-- JS for Image Preview -->
<script>
    document.getElementById('photoInput').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<?= $this->endSection() ?>