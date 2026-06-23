<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3>Create Exam Routine</h3>
        </div>

        <div class="card-body">

            <form action="<?= base_url('admin/exam-routine/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">

                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Class</label>
                        <select name="class" class="form-control">
                            <?php for ($i = 1; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Subject</label>
                        <select name="subject" class="form-control">
                            <?php foreach ($subjects as $sub): ?>
                            <option value="<?= $sub['id'] ?>">
                                <?= $sub['subject'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Sub Category</label>
                        <select name="subcategory" class="form-control">
                            <option value="Half Yearly Exam">Half Yearly Exam</option>
                            <option value="Annual Exam">Annual Exam</option>
                            <option value="Pre-Test Exam">Pre-Test Exam</option>
                            <option value="Test Exam">Test Exam</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Color</label>
                        <input type="color" name="color" class="form-control" value="#007bff">
                    </div>

                </div>

                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control">
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-success">Save</button>
                    <a href="<?= base_url('admin/exam-routine') ?>" class="btn btn-secondary">Back</a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>