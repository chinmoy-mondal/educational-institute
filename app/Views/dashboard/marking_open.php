<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <!-- Page header -->
            <section class="content-header">
                <div class="container-fluid">
                    <h1 class="text-center">Marking Action</h1>
                </div>
            </section>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Select Exam(s) and Status</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('marking_open/process') ?>">

                                <!-- Status Dropdown -->
                                <div class="form-group mb-3">
                                    <label for="status">Status for selected exams</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="open" selected>Open</option>
                                        <option value="closed">Close</option>
                                    </select>
                                </div>

                                <!-- Exams Checkboxes -->
                                <div class="form-group">
                                    <?php foreach ($exam_name as $exam): ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="exam_name[]"
                                                value="<?= esc($exam['subcategory']) ?>"
                                                id="exam_<?= esc($exam['subcategory']) ?>">
                                            <label class="form-check-label" for="exam_<?= esc($exam['subcategory']) ?>">
                                                <?= esc($exam['subcategory']) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Save
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
<?= $this->endSection() ?>