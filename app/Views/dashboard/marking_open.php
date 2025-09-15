<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="content-wrapper">
    <!-- Page header -->
    <section class="content-header">
        <div class="container-fluid">
            <h1><?= esc($title) ?></h1>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">Select Exam</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= base_url('marking_open/process') ?>">
                        <div class="form-group">
                            <label for="exam_name">Exam Name</label>
                            <select name="exam_name" id="exam_name" class="form-control">
                                <option value="">-- Select Exam --</option>
                                <?php foreach ($exam_name as $exam): ?>
                                    <option value="<?= esc($exam['subcategory']) ?>">
                                        <?= esc($exam['subcategory']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Open Marking
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </section>
</div>
<?= $this->endSection() ?>