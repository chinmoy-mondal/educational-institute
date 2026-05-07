<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                Patients Management
            </h2>

            <p class="text-muted mb-0">
                Manage all clinic patients
            </p>
        </div>

        <a href="<?= base_url('dashboard/patients/create') ?>" class="btn btn-primary rounded-3">
            <i class="fas fa-plus me-1"></i> Add Patient
        </a>

    </div>

    <!-- PATIENTS LIST -->
    <div class="row g-4">

        <?php if (!empty($patients)): ?>

        <?php foreach ($patients as $patient): ?>

        <div class="col-xl-3 col-md-4 col-sm-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body text-center">

                    <!-- AVATAR -->
                    <img src="https://i.pravatar.cc/100?img=<?= esc($patient['id']) ?>" class="rounded-circle mb-3"
                        width="70">

                    <!-- NAME -->
                    <h6 class="fw-bold mb-1">
                        <?= esc($patient['name']) ?>
                    </h6>

                    <!-- EMAIL -->
                    <small class="text-muted d-block mb-2">
                        <?= esc($patient['email']) ?>
                    </small>

                    <!-- ROLE / TYPE -->
                    <span class="badge bg-info mb-3">
                        Patient
                    </span>

                    <!-- 🆔 PATIENT NID -->
                    <div class="mb-3 text-start">

                        <label class="form-label small text-muted">
                            Patient NID
                        </label>

                        <input type="text" class="form-control form-control-sm"
                            value="<?= esc($patient['nid'] ?? '') ?>" placeholder="Enter NID">

                    </div>

                    <!-- STATUS -->
                    <div>

                        <?php if (($patient['account_status'] ?? 0) == 1): ?>
                        <span class="badge bg-success">Active</span>
                        <?php else: ?>
                        <span class="badge bg-danger">Inactive</span>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

        <?php endforeach; ?>

        <?php else: ?>

        <!-- EMPTY STATE -->
        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body text-center py-5">

                    <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>

                    <h5>No Patients Found</h5>

                    <p class="text-muted">
                        Add your first patient
                    </p>

                    <a href="<?= base_url('dashboard/patients/create') ?>" class="btn btn-primary">
                        Add Patient
                    </a>

                </div>

            </div>

        </div>

        <?php endif; ?>

    </div>

</div>

<?= $this->endSection() ?>