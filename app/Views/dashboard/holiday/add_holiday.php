<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
        <?php endif; ?>

        <div class="card card-primary mt-3 mb-3">
            <div class="card-header">
                <h3 class="card-title">
                    <?= isset($holiday) ? 'Edit Holiday' : 'Add Holiday' ?>
                </h3>
            </div>

            <form action="<?= isset($holiday)
                                ? base_url('admin/holiday/update/' . $holiday['id'])
                                : base_url('admin/holiday/add') ?>" method="post">

                <?= csrf_field() ?>

                <div class="card-body">

                    <!-- Holiday Name -->
                    <div class="form-group">
                        <label>Holiday Name</label>
                        <input type="text" name="name" value="<?= $holiday['name'] ?? old('name') ?>"
                            class="form-control" placeholder="Enter holiday name" required>
                    </div>

                    <!-- Start Date -->
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start_date" value="<?= $holiday['start_date'] ?? old('start_date') ?>"
                            class="form-control" required>
                    </div>

                    <!-- End Date -->
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end_date" value="<?= $holiday['end_date'] ?? old('end_date') ?>"
                            class="form-control" required>
                    </div>

                    <!-- Description -->
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="desc" class="form-control" rows="3"
                            placeholder="Optional"><?= $holiday['desc'] ?? old('desc') ?></textarea>
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i>
                        <?= isset($holiday) ? 'Update' : 'Save' ?>
                    </button>

                    <a href="<?= base_url('admin/holiday') ?>" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>

        </div>

    </div>
</section>

<?= $this->endSection() ?>