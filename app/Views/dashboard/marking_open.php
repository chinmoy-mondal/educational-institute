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

            <div class="row justify-content-center">
                <div class="col-md-6"> <!-- centers the card, width 6/12 -->
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

                                <div class="text-center mt-3">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-check"></i> Open Marking
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