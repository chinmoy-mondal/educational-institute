<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-1">Users Management</h2>
            <p class="text-muted mb-0">
                All system users list
            </p>
        </div>

    </div>

    <!-- ALERT -->
    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="fas fa-exclamation-circle me-1"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <i class="fas fa-check-circle me-1"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- TABLE -->
    <?php if (!empty($users)): ?>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($users as $key => $user): ?>

                        <tr>

                            <td><?= $key + 1 ?></td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://i.pravatar.cc/50?img=<?= esc($user['id']) ?>"
                                        class="rounded-circle me-2" width="40">

                                    <strong>
                                        <?= esc($user['name'] ?? '-') ?>
                                    </strong>
                                </div>
                            </td>

                            <td><?= esc($user['email'] ?? '-') ?></td>

                            <td><?= esc($user['phone'] ?? '-') ?></td>

                            <td>
                                <span class="badge bg-primary">
                                    <?= esc($user['role'] ?? 'User') ?>
                                </span>
                            </td>

                            <td>
                                <?php if (($user['status'] ?? 1) == 1): ?>
                                <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?= !empty($user['created_at'])
                                            ? date('d M Y', strtotime($user['created_at']))
                                            : '-' ?>
                            </td>

                            <td class="text-end">

                                <a href="<?= base_url('dashboard/users/edit/' . $user['id']) ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="<?= base_url('dashboard/users/delete/' . $user['id']) ?>"
                                    class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">
                                    Delete
                                </a>

                            </td>

                        </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <?php else: ?>

    <!-- EMPTY -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body text-center py-5">

            <i class="fas fa-users fa-3x text-muted mb-3"></i>

            <h5>No Users Found</h5>

            <p class="text-muted">No users available in system</p>

        </div>

    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>