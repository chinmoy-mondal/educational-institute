<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <!-- Success Message -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php endif; ?>

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Make Top Sheet</h3>
            </div>

            <form action="<?= base_url('admin/topsheet') ?>" method="get">
                <div class="card-body">

                    <div class="row">

                        <!-- Class -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Class</label>
                                <select name="class" class="form-control" required>
                                    <option value="">Select Class</option>
                                    <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Year -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Year</label>
                                <input type="number" name="year" value="<?= date('Y') ?>" class="form-control" required>
                            </div>
                        </div>

                        <!-- Section -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Section</label>
                                <select name="section" class="form-control">
                                    <option value="general">General</option>
                                    <option value="General - Humanities">General → Humanities</option>
                                    <option value="science">Science</option>
                                    <option value="commerce">Commerce</option>
                                    <option value="vocational">Vocational</option>
                                </select>
                            </div>
                        </div>

                        <!-- Exam -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Exam</label>
                                <select name="exam" class="form-control" required>
                                    <option value="">Select Exam</option>
                                    <option value="Half-Yearly">Half-Yearly</option>
                                    <option value="Pre-Test Exam">Pre-Test Exam</option>
                                    <option value="Test Exam">Test Exam</option>
                                    <option value="Annual Exam">Annual Exam</option>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Make Top Sheet
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<?= $this->endSection() ?>