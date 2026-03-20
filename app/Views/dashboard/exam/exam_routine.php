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
                <input type="hidden" name="color" value="#dc3545">

                <div class="row">

                    <!-- CLASS -->
                    <div class="col-md-2">
                        <select name="class" class="form-control" required>
                            <option value="">Class</option>
                            <?php for ($i = 6; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- SUBJECT -->
                    <div class="col-md-3">
                        <select name="subject" class="form-control" required>
                            <option value="">Select Subject</option>
                            <?php foreach ($subjects as $sub): ?>
                            <option value="<?= $sub['id'] ?>">
                                <?= $sub['class'] ?> - <?= $sub['subject'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- DATE -->
                    <div class="col-md-2">
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <!-- START TIME -->
                    <div class="col-md-2">
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <!-- END TIME -->
                    <div class="col-md-2">
                        <input type="time" name="end_time" class="form-control" required>
                    </div>

                    <!-- BUTTON -->
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
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th width="280">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($events as $e): ?>
                    <tr>

                        <form action="<?= base_url('calendar/update') ?>" method="post">

                            <td>
                                <?= $e['id'] ?>
                                <input type="hidden" name="id" value="<?= $e['id'] ?>">
                                <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                                <input type="hidden" name="category" value="Exam">
                            </td>

                            <!-- CLASS -->
                            <td>
                                <select name="class" class="form-control form-control-sm">
                                    <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>" <?= ($e['class'] == $i ? 'selected' : '') ?>>
                                        <?= $i ?>
                                    </option>
                                    <?php endfor; ?>
                                </select>
                            </td>

                            <!-- SUBJECT -->
                            <td>
                                <select name="subject" class="form-control form-control-sm">
                                    <?php foreach ($subjects as $sub): ?>
                                    <option value="<?= $sub['id'] ?>"
                                        <?= ($e['subject'] == $sub['id'] ? 'selected' : '') ?>>
                                        <?= $sub['subject'] ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>

                            <!-- DATE -->
                            <td>
                                <input type="date" name="start_date" value="<?= $e['start_date'] ?>"
                                    class="form-control form-control-sm">
                            </td>

                            <!-- TIME -->
                            <td>
                                <div class="d-flex">
                                    <input type="time" name="start_time" value="<?= $e['start_time'] ?>"
                                        class="form-control form-control-sm me-1">

                                    <input type="time" name="end_time" value="<?= $e['end_time'] ?>"
                                        class="form-control form-control-sm">
                                </div>
                            </td>

                            <!-- ACTION -->
                            <td>

                                <button class="btn btn-primary btn-sm">
                                    Update
                                </button>

                        </form>

                        <!-- DELETE -->
                        <form action="<?= base_url('calendar/delete') ?>" method="post" style="display:inline-block;">
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