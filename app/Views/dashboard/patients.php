<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-1">Patients Management</h2>
            <p class="text-muted mb-0">Search patients by phone number</p>
        </div>

    </div>

    <!-- SEARCH FORM -->
    <form method="get" action="<?= base_url('dashboard/patients') ?>" class="mb-4">

        <div class="row g-2">

            <div class="col-md-4">
                <input type="text" name="phone" class="form-control" placeholder="Enter phone number..."
                    value="<?= esc($_GET['phone'] ?? '') ?>">
            </div>

            <div class="col-md-2">
                <button class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

        </div>

    </form>


    <!-- ========================= -->
    <!-- IF PATIENT FOUND -->
    <!-- ========================= -->
    <?php if (!empty($patients)): ?>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Patient</th>
                            <th>Phone</th>
                            <th>NID</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($patients as $key => $patient): ?>

                        <tr>

                            <td><?= $key + 1 ?></td>

                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://i.pravatar.cc/50?img=<?= esc($patient['id']) ?>"
                                        class="rounded-circle me-2" width="40">
                                    <?= esc($patient['name']) ?>
                                </div>
                            </td>

                            <td><?= esc($patient['phone']) ?></td>

                            <td><?= esc($patient['nid'] ?? 'N/A') ?></td>

                            <td>
                                <?php if (($patient['account_status'] ?? 0) == 1): ?>
                                <span class="badge bg-success">Active</span>
                                <?php else: ?>
                                <span class="badge bg-danger">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="<?= base_url('dashboard/patients/edit/' . $patient['id']) ?>"
                                    class="btn btn-sm btn-warning">
                                    Edit
                                </a>

                                <a href="<?= base_url('dashboard/patients/delete/' . $patient['id']) ?>"
                                    class="btn btn-sm btn-danger" onclick="return confirm('Delete this patient?')">
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

    <!-- ========================= -->
    <!-- NO PATIENT FOUND -->
    <!-- ========================= -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body text-center py-5">

            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>

            <h5>No Patient Found</h5>

            <p class="text-muted">
                No patient matched this phone number
            </p>

            <a href="<?= base_url('dashboard/patients/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Add New Patient
            </a>

        </div>

    </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>