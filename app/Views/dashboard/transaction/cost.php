<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cost Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
                    <li class="breadcrumb-item active">Cost</li>
                </ol>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <!-- Cost Entry Card -->
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-money-bill-wave"></i> Add New Cost
                </h3>
            </div>

            <form method="post" action="">
                <div class="card-body">
                    <div class="row">

                        <!-- Date -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="cost_date" class="form-control" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>

                        <!-- Cost Type -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Cost Type</label>
                                <select name="cost_type_id" class="form-control" required>
                                    <option value="">-- Select Cost Type --</option>
                                    <?php foreach ($cost_types ?? [] as $type): ?>
                                    <option value="<?= $type['id'] ?>">
                                        <?= esc($type['type_name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Add Type -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <a href="<?= base_url('admin/cost_type') ?>" target="_blank"
                                    class="btn btn-sm btn-info ml-2">
                                    <i class="fas fa-plus"></i> Add Type
                                </a>

                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" name="amount" class="form-control" placeholder="0" required>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save"></i> Save
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <!-- Cost List -->
        <div class="card card-secondary card-outline">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i> Cost History
                </h3>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Cost Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($costs)): ?>
                        <?php foreach ($costs as $i => $cost): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td><?= $cost['cost_date'] ?></td>
                            <td><?= $cost['type_name'] ?? 'N/A' ?></td>
                            <td><?= number_format($cost['amount'], 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                No cost records found
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>