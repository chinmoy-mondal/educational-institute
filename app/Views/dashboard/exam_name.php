<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Page header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="text-center"><?= esc($title) ?></h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Select Exam</h3>
                </div>
                <form action="<?= base_url('marking_action') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <!-- Hidden fields -->
                    <input type="hidden" name="user_id" value="<?= esc($user_id) ?>">
                    <input type="hidden" name="subject_id" value="<?= esc($subject_id) ?>">

                    <div class="card-body">
                        <div class="form-group">
                            <label for="exam">Choose Exam</label>
                            <select name="exam_id" id="exam" class="form-control" required>
                                <option value="">-- Select Exam --</option>
                                <?php if (!empty($exams)): ?>
                                    <?php foreach ($exams as $exam): ?>
                                        <option value="<?= esc($exam['id']) ?>">
                                            <?= esc($exam['exam_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="">No open exams available</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success">Continue</button>
                        <a href="<?= base_url('marking_open') ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection() ?>