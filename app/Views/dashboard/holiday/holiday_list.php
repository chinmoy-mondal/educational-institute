<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Add Button -->
        <a href="#" class="btn btn-primary mb-3">
            <i class="fas fa-plus"></i> Add Holiday
        </a>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Holiday List</h3>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Holiday Name</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($holidays as $h): ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $h['name'] ?></td>
                            <td><?= $h['date'] ?></td>
                            <td><?= $h['desc'] ?></td>
                            <td>
                                <a href="#" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>

    </div>
</section>

<?= $this->endSection() ?>