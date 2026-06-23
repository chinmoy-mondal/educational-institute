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

                <!-- TITLE -->
                <div class="row">
                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?= $event['title'] ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control" value="<?= $event['description'] ?>">
                    </div>
                </div>

                <!-- CLASS & SUBJECT -->
                <div class="row mt-3">

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
                        <label>Category</label>
                        <input type="text" name="category" class="form-control" value="<?= $event['category'] ?>">
                    </div>

                    <div class="col-md-3">
                        <label>Sub Category</label>
                        <select name="subcategory" class="form-control">

                            <option value="">Select Sub Category</option>

                            <option value="Half Yearly Exam"
                                <?= ($event['subcategory'] == 'Half Yearly Exam') ? 'selected' : '' ?>>
                                Half Yearly Exam
                            </option>

                            <option value="Annual Exam"
                                <?= ($event['subcategory'] == 'Annual Exam') ? 'selected' : '' ?>>
                                Annual Exam
                            </option>

                            <option value="Pre-Test Exam"
                                <?= ($event['subcategory'] == 'Pre-Test Exam') ? 'selected' : '' ?>>
                                Pre-Test Exam
                            </option>

                            <option value="Test Exam" <?= ($event['subcategory'] == 'Test Exam') ? 'selected' : '' ?>>
                                Test Exam
                            </option>

                        </select>
                    </div>

                </div>

                <!-- DATE & TIME -->
                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $event['start_date'] ?>"
                            required>
                    </div>

                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $event['end_date'] ?>">
                    </div>

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

                </div>

                <!-- COLOR -->
                <div class="row mt-3">
                    <div class="col-md-3">
                        <label>Color</label>
                        <input type="color" name="color" class="form-control" value="<?= $event['color'] ?>">
                    </div>
                </div>

                <!-- BUTTONS -->
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