<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cost Type Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Cost Types</li>
                </ol>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <!-- Add Cost Type Form -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-tags"></i> Add New Cost Type
                </h3>
            </div>

            <form method="post" action="<?= base_url('admin/cost_type') ?>" id="costTypeForm">
                <div class="card-body">
                    <div class="form-group">
                        <label>Cost Type Name</label>
                        <input type="text" name="type_name" id="type_name" class="form-control"
                            placeholder="Electricity / Repair" required>
                    </div>

                    <button type="submit" class="btn btn-success" id="saveBtn" disabled>
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>

        <!-- Cost Type List -->
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Existing Cost Types
                </h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Type Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($costTypes)): ?>
                        <?php foreach ($costTypes as $i => $type): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= esc($type['type_name']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                No cost types added yet
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<!-- JS: Activate button + prevent double submit -->
<script>
const input = document.getElementById('type_name');
const saveBtn = document.getElementById('saveBtn');
const form = document.getElementById('costTypeForm');

input.addEventListener('input', function() {
    saveBtn.disabled = this.value.trim() === '';
});

form.addEventListener('submit', function() {
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
});
</script>

<?= $this->endSection() ?>