<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>
<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <!-- Flash messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Page header -->
            <section class="content-header mb-3">
                <div class="container-fluid">
                    <h1 class="text-center">Marking Action</h1>
                </div>
            </section>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
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
                                    <?php if (!empty($exam_name)): ?>
                                        <?php foreach ($exam_name as $exam): ?>
                                            <div class="form-check mb-1">
                                                <input class="form-check-input" type="checkbox"
                                                    name="exam_name[]"
                                                    value="<?= esc($exam['exam_name']) ?>"
                                                    id="exam_<?= esc($exam['exam_name']) ?>"
                                                    <?= ($exam['status'] === 'open') ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="exam_<?= esc($exam['exam_name']) ?>">
                                                    <?= esc($exam['exam_name']) ?>
                                                    <span class="badge <?= ($exam['status'] === 'open') ? 'bg-success' : 'bg-secondary' ?>">
                                                        <?= ucfirst($exam['status']) ?>
                                                    </span>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p class="text-muted">No exams found.</p>
                                    <?php endif; ?>
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