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

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <div class="col-md-8"> <!-- a bit wider for dropdowns -->
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h3 class="card-title">Select Exam(s) and Status</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="<?= base_url('marking_open/process') ?>">

                                <div class="form-group">
                                    <?php foreach ($exam_name as $exam): ?>
                                        <div class="form-check d-flex align-items-center mb-2">
                                            <input class="form-check-input me-2" type="checkbox" 
                                                   name="exam_name[]" 
                                                   value="<?= esc($exam['subcategory']) ?>" 
                                                   id="exam_<?= esc($exam['subcategory']) ?>">

                                            <label class="form-check-label me-3" for="exam_<?= esc($exam['subcategory']) ?>">
                                                <?= esc($exam['subcategory']) ?>
                                            </label>

                                            <select name="status[<?= esc($exam['subcategory']) ?>]" class="form-select form-select-sm">
                                                <option value="open" selected>Open</option>
                                                <option value="closed">Close</option>
                                            </select>
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