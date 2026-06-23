<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3>Create Exam Routine</h3>
        </div>

        <div class="card-body">

            <form action="<?= base_url('admin/exam-routine/store') ?>" method="post">
                <?= csrf_field() ?>

                <!-- TITLE + DESCRIPTION -->
                <div class="row">

                    <div class="col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Description</label>
                        <input type="text" name="description" class="form-control">
                    </div>

                </div>

                <!-- CLASS + SUBJECT + CATEGORY + COLOR -->
                <div class="row mt-3">

                    <!-- CLASS -->
                    <div class="col-md-3">
                        <label>Class</label>
                        <select name="class" id="class" class="form-control">
                            <option value="">Select Class</option>
                            <?php for ($i = 6; $i <= 10; $i++): ?>
                            <option value="<?= $i ?>">Class <?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- SUBJECT (DYNAMIC) -->
                    <div class="col-md-3">
                        <label>Subject</label>
                        <select name="subject" id="subject" class="form-control">
                            <option value="">Select Subject</option>
                        </select>
                    </div>

                    <!-- CATEGORY -->
                    <div class="col-md-3">
                        <label>Sub Category</label>
                        <select name="subcategory" class="form-control">
                            <option value="Half Yearly Exam">Half Yearly Exam</option>
                            <option value="Annual Exam">Annual Exam</option>
                            <option value="Pre-Test Exam">Pre-Test Exam</option>
                            <option value="Test Exam">Test Exam</option>
                        </select>
                    </div>

                    <!-- COLOR -->
                    <div class="col-md-3">
                        <label>Color</label>
                        <input type="color" name="color" class="form-control" value="#007bff">
                    </div>

                </div>

                <!-- DATE TIME -->
                <div class="row mt-3">

                    <div class="col-md-3">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>Start Time</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control">
                    </div>

                </div>

                <!-- BUTTON -->
                <div class="mt-4">
                    <button class="btn btn-success">Save</button>
                    <a href="<?= base_url('admin/exam-routine') ?>" class="btn btn-secondary">Back</a>
                </div>

            </form>

        </div>
    </div>

</div>

<!-- ================= AJAX SCRIPT ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$('#class').on('change', function() {

    let classId = $(this).val();

    if (classId === "") {
        $('#subject').html('<option value="">Select Subject</option>');
        return;
    }

    $('#subject').html('<option>Loading...</option>');

    $.ajax({
        url: "<?= base_url('admin/get-subjects') ?>",
        type: "GET",
        data: {
            class: classId
        },
        dataType: "json",
        success: function(data) {

            let options = '<option value="">Select Subject</option>';

            data.forEach(function(item) {
                options += `<option value="${item.id}">${item.subject}</option>`;
            });

            $('#subject').html(options);
        },
        error: function() {
            $('#subject').html('<option value="">Error loading subjects</option>');
        }
    });

});
</script>

<?= $this->endSection() ?>