<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Make Top Sheet</h3>
            </div>

            <form action="" method="get"
                onsubmit="this.action='<?= base_url('admin/print_topsheet') ?>/' + this.class.value;">
                <div class="card-body">

                    <div class="row justify-content-center">

                        <!-- Class -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Select Class</label>
                                <select name="class" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>">Class <?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-success">
                        Make Top Sheet
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<?= $this->endSection() ?>