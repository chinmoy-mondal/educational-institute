<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
    <div class="container-fluid">

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">

                <!-- CARD -->
                <div class="card card-primary shadow-sm">

                    <div class="card-header">
                        <h3 class="card-title text-center mb-0">Make Top Sheet</h3>
                    </div>

                    <div class="card-body">

                        <form action="<?= base_url('admin/print_topsheet') ?>" method="get">

                            <!-- CLASS -->
                            <div class="form-group">
                                <label>Select Class</label>
                                <select name="class" id="class" class="form-control" required>
                                    <option value="">Select Class</option>

                                    <?php foreach ($class as $c): ?>
                                        <option value="<?= $c['class'] ?>">
                                            Class <?= $c['class'] ?>
                                        </option>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- EXAM -->
                            <div class="form-group mt-3">
                                <label>Select Exam</label>
                                <select name="exam" id="exam" class="form-control" required>
                                    <option value="">Select Exam</option>
                                </select>
                            </div>

                            <!-- SUBMIT -->
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    Make Top Sheet
                                </button>
                            </div>

                        </form>

                    </div>

                </div>

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

            // reset
            $('#exam').html('<option value="">Select Exam</option>');

            if (classId === "") return;

            let options = '<option value="">Select Exam</option>';

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

            $('#exam').html(options);

        });

    });
</script>

<?= $this->endSection() ?>