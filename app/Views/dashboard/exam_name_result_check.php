<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="d-flex flex-column align-items-center" style="padding-top: 50px; width: 100%;">

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show w-50 mb-3" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show w-50 mb-3" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Card with form -->
    <div class="card shadow-lg p-4" style="width: 500px; max-width: 90%;">
        <div class="card-header text-center bg-primary text-white">
            <h4 class="mb-0">Select Exam</h4>
        </div>
        <div class="card-body">
            <form action="<?= site_url('admin/resultCheck') ?>" method="post">
                <!-- Hidden fields for user and subject -->
                <input type="hidden" name="user_id" value="<?= esc($user_id) ?>">
                <input type="hidden" name="subject_id" value="<?= esc($subject_id) ?>">

                <?php if (!empty($exams)): ?>
                    <div class="mb-3">
                        <label class="fw-bold d-block mb-2">Available Exams:</label>
                        <?php foreach ($exams as $exam): ?>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio"
                                    name="exam_name"
                                    id="exam<?= esc($exam['exam_name']) ?>"
                                    value="<?= esc($exam['exam_name']) ?>" required>
                                <label class="form-check-label" for="exam<?= esc($exam['exam_name']) ?>">
                                    <?= esc($exam['exam_name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-danger text-center">No open exams available</p>
                <?php endif; ?>

                <div class="d-flex justify-content-between mt-4">
                    <a href="<?= base_url('marking_open') ?>" class="btn btn-secondary px-4">Cancel</a>
                    <button type="submit" class="btn btn-success px-4">Continue</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>