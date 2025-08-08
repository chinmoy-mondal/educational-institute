<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php
            // Determine profile picture path
            $profilePicture = session('picture');
            $profilePictureUrl = (!empty($profilePicture) && file_exists(FCPATH . $profilePicture))
                ? base_url($profilePicture)
                : base_url('public/assets/img/default-user.png');
            ?>

            <!-- Profile Card -->
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- Profile Header -->
                    <div class="d-flex align-items-center mb-4">
                        <img src="<?= $profilePictureUrl ?>"
                             alt="Profile Picture"
                             class="rounded-circle border"
                             width="100" height="100">
                        <div class="ms-3">
                            <h4 class="mb-0"><?= esc(session('name') ?? 'Unknown') ?></h4>
                            <span class="badge bg-primary"><?= esc(session('role') ?? 'N/A') ?></span>
                            <div class="text-muted small">
                                Account Status:
                                <span class="<?= session('account_status') == 'active' ? 'text-success' : 'text-danger' ?>">
                                    <?= ucfirst(session('account_status') ?? 'Unknown') ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information Table -->
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th width="30%">Designation</th>
                                <td><?= esc(session('designation') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Subject</th>
                                <td><?= esc(session('subject') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Assigned Subject</th>
                                <td><?= esc(session('assagin_sub') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?= esc(session('gender') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <td><?= esc(session('religion') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td><?= esc(session('blood_group') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?= esc(session('phone') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= esc(session('email') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Permit By</th>
                                <td><?= esc(session('permit_by') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <td><?= esc(session('created_at') ?? 'N/A') ?></td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td><?= esc(session('updated_at') ?? 'N/A') ?></td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>