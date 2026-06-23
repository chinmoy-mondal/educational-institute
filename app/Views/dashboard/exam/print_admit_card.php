<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">

                <!-- CARD -->
                <div class="card card-primary shadow-sm">

                    <div class="card-header">
                        <h3 class="card-title">Exam Selection</h3>
                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('print-admit') ?>" method="post">

                            <!-- CLASS -->
                            <div class="form-group">
                                <label>Class</label>
                                <select id="class" name="class" class="form-control" required>
                                    <option value="">-- Select Class --</option>

                                    <?php for ($i = 6; $i <= 10; $i++): ?>
                                        <option value="<?= $i ?>">Class <?= $i ?></option>
                                    <?php endfor; ?>

                                </select>
                            </div>

                            <!-- SECTION -->
                            <div class="form-group">
                                <label>Section</label>
                                <select id="section" name="section" class="form-control" required>
                                    <option value="">-- Select Section --</option>
                                    <option value="General">General</option>
                                    <option value="Vocational">Vocational</option>
                                </select>
                            </div>

                            <!-- YEAR -->
                            <div class="form-group">
                                <label>Year</label>
                                <select id="year" name="year" class="form-control" required>
                                    <option value="">-- Select Year --</option>

                                    <?php for ($y = date('Y'); $y >= 2015; $y--): ?>
                                        <option value="<?= $y ?>"><?= $y ?></option>
                                    <?php endfor; ?>

                                </select>
                            </div>

                            <!-- EXAM -->
                            <div class="form-group">
                                <label>Exam Name</label>
                                <select id="exam_name" name="exam_name" class="form-control" required>
                                    <option value="">-- Select Exam --</option>
                                </select>
                            </div>

                            <!-- BUTTON -->
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-success btn-block">
                                    Submit
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
                <!-- END CARD -->

            </div>
        </div>

    </div>
</section>

<!-- ================= JS ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        $('#class').on('change', function() {

            let classId = $(this).val();

            let options = '<option value="">-- Select Exam --</option>';

            // CLASS 10
            if (classId == 10) {
                options += `
                <option value="Pre-Test Exam">Pre-Test Exam</option>
                <option value="Test Exam">Test Exam</option>
            `;
            }

            // CLASS 6–9
            else if (classId >= 6 && classId <= 9) {
                options += `
                <option value="Half Yearly Exam">Half Yearly Exam</option>
                <option value="Annual Exam">Annual Exam</option>
            `;
            }

            $('#exam_name').html(options);

        });

    });
</script>

<?= $this->endSection() ?>