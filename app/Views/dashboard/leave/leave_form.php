<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="mb-3">
        <h4>Apply for Leave</h4>
    </div>

    <!-- LEAVE FORM -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Leave Application Form</h3>
        </div>

        <form action="<?= base_url('admin/leave/save') ?>" method="post">
            <?= csrf_field() ?>

            <div class="card-body">

                <!-- ONE LINE: Leave Type, From Date, To Date -->
                <div class="row">

                    <!-- Leave Type -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Leave Type</label>
                            <select name="leave_type" class="form-control" required>
                                <option value="">Select Leave Type</option>
                                <option value="Casual">Casual Leave</option>
                                <option value="Sick">Sick Leave</option>
                                <option value="Emergency">Emergency Leave</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>

                    <!-- From Date -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control" required>
                        </div>
                    </div>

                    <!-- To Date -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control" required>
                        </div>
                    </div>

                </div>

                <!-- Total Days (Auto) -->
                <div class="form-group">
                    <label>Total Days</label>
                    <input type="text" id="total_days" class="form-control" readonly>
                </div>

                <!-- Reason -->
                <div class="form-group">
                    <label>Reason</label>
                    <textarea name="reason" class="form-control" rows="4" placeholder="Enter reason..."
                        required></textarea>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>

            </div>

            <!-- SUBMIT -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit Leave</button>
                <a href="<?= base_url('admin/leave') ?>" class="btn btn-secondary">Back</a>
            </div>

        </form>
    </div>

</div>

<!-- AUTO CALCULATE TOTAL DAYS -->
<script>
document.getElementById('from_date').addEventListener('change', calculateDays);
document.getElementById('to_date').addEventListener('change', calculateDays);

function calculateDays() {
    let from = document.getElementById('from_date').value;
    let to = document.getElementById('to_date').value;

    if (from && to) {
        let fromDate = new Date(from);
        let toDate = new Date(to);

        let timeDiff = toDate - fromDate;
        let days = (timeDiff / (1000 * 60 * 60 * 24)) + 1;

        if (days >= 0) {
            document.getElementById('total_days').value = days + " day(s)";
        } else {
            document.getElementById('total_days').value = "Invalid date";
        }
    }
}
</script>

<?= $this->endSection() ?>