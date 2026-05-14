<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h2 class="fw-bold mb-1">Patients Management</h2>
            <p class="text-muted mb-0">
                Search patients instantly (name, phone, address, gender, age)
            </p>
        </div>

    </div>

    <!-- ALERT MESSAGE -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- SEARCH -->
    <div class="row g-2 mb-4">

        <div class="col-md-4">

            <input type="tel" id="patientSearch" class="form-control" placeholder="Search patient..." maxlength="11"
                inputmode="numeric" pattern="[0-9]*" oninput="filterPatients(this.value)">

        </div>

    </div>

    <!-- TABLE -->
    <?php if (!empty($patients)): ?>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Patient</th>
                                <th>Phone</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach ($patients as $key => $patient): ?>

                                <tr class="patientRow" data-search="<?= strtolower(
                                                                        ($patient['name'] ?? '') . ' ' .
                                                                            ($patient['phone'] ?? '') . ' ' .
                                                                            ($patient['address'] ?? '') . ' ' .
                                                                            ($patient['gender'] ?? '') . ' ' .
                                                                            ($patient['age'] ?? '')
                                                                    ) ?>">

                                    <td><?= $key + 1 ?></td>

                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://i.pravatar.cc/50?img=<?= esc($patient['id']) ?>"
                                                class="rounded-circle me-2" width="40">

                                            <strong><?= esc($patient['name'] ?? '-') ?></strong>
                                        </div>
                                    </td>

                                    <td><?= esc($patient['phone'] ?? '-') ?></td>

                                    <td><?= esc($patient['age'] ?? '-') ?></td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            <?= esc($patient['gender'] ?? '-') ?>
                                        </span>
                                    </td>

                                    <td><?= esc($patient['address'] ?? '-') ?></td>

                                    <td>
                                        <?= !empty($patient['created_at'])
                                            ? date('d M Y', strtotime($patient['created_at']))
                                            : '-' ?>
                                    </td>

                                    <td>
                                        <?php if (($patient['account_status'] ?? 1) == 1): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-end">

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

    <?php endif; ?>

    <!-- NO RESULT BOX -->
    <div id="noResultBox" class="text-center py-5 d-none">

        <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>

        <h5>No Patient Found</h5>

        <p class="text-muted">
            No matching patient found
        </p>

        <button type="button" class="btn btn-primary" onclick="goToCreate()">
            <i class="fas fa-plus me-1"></i>
            Create New Patient
        </button>

    </div>

</div>

<!-- SCRIPT -->
<script>
    function filterPatients(value) {
        // keep only numbers
        value = value.replace(/[^0-9]/g, '');

        // force max 11 digits
        if (value.length > 11) {
            value = value.slice(0, 11);
        }

        document.getElementById('patientSearch').value = value;

        let rows = document.querySelectorAll('.patientRow');
        let found = false;

        rows.forEach(function(row) {
            let text = row.getAttribute('data-search') || '';

            if (text.includes(value)) {
                row.style.display = '';
                found = true;
            } else {
                row.style.display = 'none';
            }
        });

        let noResultBox = document.getElementById('noResultBox');

        if (found) {
            noResultBox.classList.add('d-none');
        } else {
            noResultBox.classList.remove('d-none');
        }
    }


    function goToCreate() {
        let phone = document.getElementById('patientSearch').value.replace(/[^0-9]/g, '');

        if (phone.length !== 11) {
            alert('Phone number must be exactly 11 digits');
            return;
        }

        window.location.href = "<?= base_url('dashboard/patients/create') ?>?phone=" + phone;
    }
</script>

<?= $this->endSection() ?>