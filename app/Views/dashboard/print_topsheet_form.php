<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">

                <!-- Card Start -->
                <div class="card card-primary shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title text-center mb-0">Make Top Sheet</h3>
                    </div>

                    <div class="card-body">
                        <form action="<?= base_url('admin/print_topsheet') ?>" method="get">

                            <!-- Class Dropdown -->
                            <div class="form-group">
                                <label for="class">Select Class</label>
                                <select name="class" id="class" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <?php foreach ($class as $c): ?>
                                    <option value="<?= $c['class'] ?>">Class <?= $c['class'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Make Top Sheet
                                </button>
                            </div>

                        </form>
                    </div> <!-- /.card-body -->

                </div> <!-- /.card -->
                <!-- Card End -->

            </div> <!-- /.col-md-6 -->
        </div> <!-- /.row -->

    </div> <!-- /.container-fluid -->
</section>

<?= $this->endSection() ?>