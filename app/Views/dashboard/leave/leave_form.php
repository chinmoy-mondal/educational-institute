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

                <!-- Leave Type -->
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

                <!-- From Date -->
                <div class="form-group">
                    <label>From Date</label>
                    <input type="date" name="from_date" class="form-control" required>
                </div>

                <!-- To Date -->
                <div class="form-group">
                    <label>To Date</label>
                    <input type="date" name="to_date" class="form-control" required>
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

<?= $this->endSection() ?>