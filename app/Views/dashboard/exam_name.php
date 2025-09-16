<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card p-4 shadow-lg" style="width: 400px;">
        <h4 class="text-center mb-3">Select Exam</h4>

        <form action="<?= site_url('ad-result') ?>" method="post">
            <!-- Hidden fields for user and subject -->
            <input type="hidden" name="user_id" value="<?= esc($user_id) ?>">
            <input type="hidden" name="subject_id" value="<?= esc($subject_id) ?>">

            <?php if (!empty($exams)): ?>
                <?php foreach ($exams as $exam): ?>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio"
                            name="exam_name"
                            value="<?= esc($exam['exam_name']) ?>" required>
                        <label class="form-check-label">
                            <?= esc($exam['exam_name']) ?>
                        </label>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-danger text-center">No open exams available</p>
            <?php endif; ?>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary px-4">Submit</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>