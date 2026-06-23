<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Create Exam Routine</h5>
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
                        <label>Category</label>
                        <select name="category" id="category" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Exam">Exam</option>
                            <option value="Notice">Notice</option>
                            <option value="Holiday">Holiday</option>
                            <option value="Vacation">Vacation</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Sub Category</label>
                        <select name="subcategory" id="subcategory" class="form-control">
                            <option value="">Select Sub Category</option>
                            <option>Half Yearly Exam</option>
                            <option>Annual Exam</option>
                            <option>Pre-Test Exam</option>
                            <option>Test Exam</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Class</label>
                        <select name="class" class="form-control">
                            <?php for ($i = 6; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Subject</label>
                        <select name="subject" class="form-control">
                            <?php foreach ($subjects as $sub): ?>
                            <option value="<?= $sub['id'] ?>">
                                <?= $sub['class'] ?> - <?= $sub['subject'] ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
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

                <div class="mt-3">
                    <label>Color</label>
                    <input type="color" name="color" class="form-control" value="#007bff">
                </div>

                <div class="mt-4">
                    <button class="btn btn-success">Save Routine</button>
                    <a href="<?= base_url('admin/exam-routine') ?>" class="btn btn-secondary">Back</a>
                </div>

            </form>

        </div>
    </div>

</div>

<?= $this->endSection() ?>