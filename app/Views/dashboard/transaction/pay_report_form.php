<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <!-- Card -->
    <div class="card card-outline card-primary shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-alt"></i> Generate Payment Report
            </h5>
        </div>

        <div class="card-body">
            <form action="<?= base_url('admin/pay_report_result') ?>" method="post">

                <div class="row g-3">

                    <!-- Start Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Start Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- End Date -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">End Date</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-check"></i>
                            </span>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- Transaction Type -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Transaction Type</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-exchange-alt"></i>
                            </span>
                            <select name="type" class="form-control">
                                <option value="all">All Transactions</option>
                                <option value="student">Student Payment</option>
                                <option value="teacher">Teacher Payment</option>
                                <option value="salary">Salary</option>
                                <option value="cost">Cost / Expense</option>
                            </select>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-search"></i> Generate Report
                        </button>
                    </div>

                </div>

            </form>
        </div>
    </div>

</div>

<?= $this->endSection() ?>