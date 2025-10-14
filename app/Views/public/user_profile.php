<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content py-5">

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card card-primary card-outline shadow-sm">
                <div class="card-header text-center">
                    <h3 class="card-title fw-bold"><?= esc($user['name']); ?></h3>
                    <p class="text-muted mb-0"><?= esc(strtoupper($user['designation'])); ?></p>
                    <p class="text-muted small mb-0"><?= esc($user['subject']); ?></p>
                </div>

                <div class="card-body text-center">
                    <!-- Profile Image -->
                    <img src="<?= base_url($user['picture'] ?? 'public/assets/img/default.jpg') ?>"
                         class="img-fluid img-circle mb-3"
                         style="width:150px; height:150px; object-fit:cover; border:4px solid #f1f1f1;"
                         alt="<?= esc($user['name']); ?>">

                    <!-- User Info Table -->
                    <table class="table table-bordered table-striped mt-3 text-start">
                        <tbody>
                            <tr>
                                <th>Role</th>
                                <td><?= esc($user['role']); ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?= esc($user['gender']); ?></td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <td><?= esc($user['religion']); ?></td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td><?= esc($user['blood_group']); ?></td>
                            </tr>
                            <tr>
                                <th>DOB</th>
                                <td><?= esc($user['dob']); ?></td>
                            </tr>
                            <tr>
                                <th>Joining Date</th>
                                <td><?= esc($user['joining_date']); ?></td>
                            </tr>
                            <tr>
                                <th>MPO Date</th>
                                <td><?= esc($user['mpo_date']); ?></td>
                            </tr>
                            <tr>
                                <th>Bio</th>
                                <td style="white-space: pre-line;"><?= esc($user['bio'], 'raw'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Card Footer -->
                <div class="card-footer text-center">
                    <!-- Email -->
                    <?php if (!empty($user['email'])): ?>
                        <a href="mailto:<?= esc($user['email']); ?>" class="btn btn-outline-primary btn-sm mx-1">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                    <?php endif; ?>

                    <!-- Phone -->
                    <?php if (!empty($user['phone'])): ?>
                        <a href="tel:<?= esc($user['phone']); ?>" class="btn btn-outline-primary btn-sm mx-1">
                            <i class="fas fa-phone"></i> Call
                        </a>
                    <?php endif; ?>

                    <!-- Social Profile -->
                    <?php if (!empty($user['social_profile'])): ?>
                        <?php
                            $social = $user['social_profile'];
                            $url = '#';
                            $icon = 'fab fa-linkedin';

                            if (str_starts_with($social, 'f:')) {
                                $icon = 'fab fa-facebook';
                                $url = substr($social, 2);
                            } elseif (str_starts_with($social, 'y:')) {
                                $icon = 'fab fa-youtube';
                                $url = substr($social, 2);
                            } elseif (str_starts_with($social, 'l:')) {
                                $icon = 'fab fa-linkedin';
                                $url = substr($social, 2);
                            }
                            $url = trim($url);
                        ?>
                        <a href="<?= esc($url) ?>" target="_blank" class="btn btn-outline-primary btn-sm mx-1">
                            <i class="<?= esc($icon) ?>"></i> Profile
                        </a>
                    <?php endif; ?>

                    <!-- ID Card -->
                    <a href="<?= base_url('teacher_idcard/' . $user['id']) ?>" target="_blank" class="btn btn-outline-primary btn-sm mx-1">
                        <i class="fas fa-id-card"></i> Card
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>

<?= $this->include("layouts/base-structure/footer"); ?>
<?= $this->endSection(); ?>