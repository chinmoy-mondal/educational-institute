<!-- chinmoy is testing new code -->

<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content">

    <!-- Form Section -->
    <section class="py-5">
        <div class="container">

            <div class="card shadow-sm rounded-3 p-4 mx-auto" style="max-width: 500px;">

                <h4 class="mb-4 fw-bold text-center">Exam Selection</h4>

                <form action="<?= base_url('print-admit') ?>" method="post">

                    <!-- CLASS -->
                    <div class="mb-3">
                        <label for="class" class="form-label">Class</label>
                        <select id="class" name="class" class="form-select" required>
                            <option value="">-- Select Class --</option>

                            <?php for ($i = 6; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>

                        </select>
                    </div>

                    <!-- SECTION -->
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <select id="section" name="section" class="form-select" required>
                            <option value="">-- Select Section --</option>
                            <option value="General">General</option>
                            <option value="Vocational">Vocational</option>
                        </select>
                    </div>

                    <!-- YEAR -->
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <select id="year" name="year" class="form-select" required>
                            <option value="">-- Select Year --</option>

                            <?php for ($y = date('Y'); $y >= 2015; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                            <?php endfor; ?>

                        </select>
                    </div>

                    <!-- EXAM (DYNAMIC) -->
                    <div class="mb-4">
                        <label for="exam_name" class="form-label">Exam Name</label>
                        <select id="exam_name" name="exam_name" class="form-select" required>
                            <option value="">-- Select Exam --</option>
                        </select>
                    </div>

                    <!-- SUBMIT -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4">
                            Submit
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </section>

</div>

<?= $this->include("layouts/base-structure/footer"); ?>

<!-- ================= JS ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    $('#class').on('change', function() {

        let classId = $(this).val();

        let options = '<option value="">-- Select Exam --</option>';

        // ================= CLASS 10 =================
        if (classId == 10) {

            options += `
                <option value="Pre-Test Exam">Pre-Test Exam</option>
                <option value="Test Exam">Test Exam</option>
            `;

        }

        // ================= CLASS 6–9 =================
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

<?= $this->endSection(); ?>