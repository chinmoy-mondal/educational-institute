<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Make Top Sheet</h3>
            </div>

            <form action="<?= base_url('admin/print_topsheet') ?>" method="get">
                <div class="form-group">
                    <label>Select Class</label>
                    <select name="class" class="form-control" required>
                        <option value="">Select Class</option>
                        <?php foreach ($class as $c): ?>
                        <option value="<?= $c['class'] ?>">Class <?= $c['class'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-success">Make Top Sheet</button>
            </form>
        </div>

    </div>
</section>

<?= $this->endSection() ?>