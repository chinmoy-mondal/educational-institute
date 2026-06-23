<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Exam Routine</h3>
        </div>

        <div class="card-body">

            <form action="<?= base_url('admin/exam-routine/update/' . $event['id']) ?>" method="post">

                <?= csrf_field() ?>

                <div class="row">

                    <div class="col-md-3">
                        <label>Class</label>
                        <select name="class" class="form-control" required>
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>" <?= ($event['class'] == $i) ? 'selected' : '' ?>>
                                Class <?= $i ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Subject</label>
                        <select name="subject" class="form-control" required>

                            <?php foreach ($subjects as $sub): ?>
                            <option value="<?= $sub['id'] ?>"
                                <?= ($event['subject'] == $sub['id']) ? 'selected' : '' ?>>
                                <?= $sub['subject'] ?>
                            </option>
                            <?php endforeach; ?>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Exam Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $event['start_date'] ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label>Color</label>
                        <input type="color" name="color" class="form-control" value="<?= $event['color'] ?>">
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="<?= $event['start_time'] ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" value="<?= $event['end_time'] ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label>Category</label>
                        <input type="text" class="form-control" value="Exam" readonly>
                    </div>

                </div>

                <div class="mt-4">

                    <button type="submit" class="btn btn-success">
                        Update Routine
                    </button>

                    <a href="<?= base_url('admin/exam-routine') ?>" class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>