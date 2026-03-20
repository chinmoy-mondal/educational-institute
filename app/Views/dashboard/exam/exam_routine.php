<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- ADD EXAM ROUTINE -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add Exam Routine</h3>
        </div>

        <form action="<?= base_url('calendar/add') ?>" method="post">
            <div class="card-body">

                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                <input type="hidden" name="category" value="Exam">

                <div class="row">

                    <div class="col-md-2">
                        <select name="class" class="form-control" required>
                            <option value="">Class</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="text" name="title" class="form-control" placeholder="Exam Name (e.g. Math)"
                            required>
                    </div>

                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <div class="col-md-1">
                        <button class="btn btn-success btn-block">Add</button>
                    </div>

                </div>

            </div>
        </form>
    </div>

    <!-- EXAM ROUTINE LIST -->
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="card-title">Exam Routine List</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($events as $e): ?>
                    <tr>
                        <td><?= $e['id'] ?></td>
                        <td><?= $e['class'] ?></td>
                        <td><?= esc($e['title']) ?></td>
                        <td><?= $e['start_date'] ?></td>
                        <td><?= $e['start_time'] ?> - <?= $e['end_time'] ?></td>

                        <td>

                            <!-- EDIT -->
                            <form action="<?= base_url('calendar/update') ?>" method="post"
                                style="display:inline-block;">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                <input type="hidden" name="id" value="<?= $e['id'] ?>">

                                <input type="text" name="title" value="<?= esc($e['title']) ?>" style="width:90px">
                                <input type="date" name="start_date" value="<?= $e['start_date'] ?>">

                                <button class="btn btn-primary btn-sm">Update</button>
                            </form>

                            <!-- DELETE -->
                            <form action="<?= base_url('calendar/delete') ?>" method="post"
                                style="display:inline-block;">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                <input type="hidden" name="id" value="<?= $e['id'] ?>">

                                <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this exam?')">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>