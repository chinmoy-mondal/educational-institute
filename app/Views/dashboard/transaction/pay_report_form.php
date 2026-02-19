<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📅 Generate Payment Report</h5>
        </div>

        <div class="card-body">
            <form action="<?= base_url('admin/pay_report_result') ?>" method="post">

                <div class="row">

                    <div class="col-md-4">
                        <label>Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Transaction Type</label>
                        <select name="type" class="form-control">
                            <option value="all">All</option>
                            <option value="student">Student Payment</option>
                            <option value="teacher">Teacher Payment</option>
                            <option value="salary">Salary</option>
                            <option value="cost">Cost/Expense</option>
                        </select>
                    </div>

                </div>

                <button class="btn btn-success w-100 mt-3">
                    🔍 Generate Report
                </button>

            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>