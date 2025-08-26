<!-- chinmoy is testing new code -->

<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!--  Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>
<div class="container content">
    <!--start Form Section-->
    <section class="py-5">
        <div class="container">
            <div class="card shadow-sm rounded-3 p-4">
                <h4 class="mb-3 fw-bold text-center">Exam Selection</h4>
                <form action="<?= base_url('print-admit') ?>" method="post">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="class" class="form-label">Class</label>
                            <select id="class" name="class" class="form-select" required>
                                <option value="">-- Select Class --</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>">Class <?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="section" class="form-label">Section</label>
                            <select id="section" name="section" class="form-select" required>
                                <option value="">-- Select Section --</option>
                                <option value="A">Section A</option>
                                <option value="B">Section B</option>
                                <option value="C">Section C</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="year" class="form-label">Year</label>
                            <select id="year" name="year" class="form-select" required>
                                <option value="">-- Select Year --</option>
                                <?php for ($y = date('Y'); $y >= 2015; $y--): ?>
                                    <option value="<?= $y ?>"><?= $y ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exam_name" class="form-label">Exam Name</label>
                            <select id="exam_name" name="exam_name" class="form-select" required>
                                <option value="">-- Select Exam --</option>
                                <option value="First Term">First Term</option>
                                <option value="Second Term">Second Term</option>
                                <option value="Final">Final</option>
                                <option value="Test Exam">Test Exam</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="group" class="form-label">Group</label>
                            <select id="group" name="group" class="form-select">
                                <option value="">-- Select Group (if any) --</option>
                                <option value="General">General</option>
                                <option value="Science">Science</option>
                                <option value="Commerce">Commerce</option>
                                <option value="Humanities">Humanities</option>
                                <option value="Vocational">Vocational</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!--end Form Section-->

</div>

<?= $this->include("layouts/base-structure/footer"); ?>
<?= $this->endSection(); ?>