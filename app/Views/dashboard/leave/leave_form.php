<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- PAGE HEADER -->
    <div class="mb-3">
        <h4><?= isset($leave) ? 'Edit Leave' : 'Apply for Leave' ?></h4>
    </div>

    <!-- USER INFO + BALANCE -->
    <div class="alert alert-info">
        <strong>Name:</strong> <?= esc($user['name']) ?> |
        <strong>Email:</strong> <?= esc($user['email']) ?> <br>

        <strong>Total Allowed:</strong> <?= $totalAllowedLeaves ?> |
        <strong>Used:</strong> <?= $usedLeaves ?> |
        <strong>Remaining:</strong> <?= $remainingLeaves ?>
    </div>

    <!-- FORM -->
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">
                <?= isset($leave) ? 'Update Leave Form' : 'Leave Application Form' ?>
            </h3>
        </div>

        <form action="<?= base_url('admin/leave/save') ?>" method="post">
            <?= csrf_field() ?>

            <!-- 🔴 IMPORTANT: ID for update -->
            <input type="hidden" name="id" value="<?= $leave['id'] ?? '' ?>">

            <!-- USER ID -->
            <input type="hidden" name="user_id" value="<?= esc($user['id']) ?>">

            <div class="card-body">

                <div class="row">

                    <!-- Leave Type -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Leave Type</label>
                            <select name="leave_type" class="form-control" required>
                                <option value="">Select</option>

                                <option value="Casual"
                                    <?= (isset($leave) && $leave['leave_type'] == 'Casual') ? 'selected' : '' ?>>
                                    Casual Leave
                                </option>

                                <option value="Sick"
                                    <?= (isset($leave) && $leave['leave_type'] == 'Sick') ? 'selected' : '' ?>>
                                    Sick Leave
                                </option>

                                <option value="Emergency"
                                    <?= (isset($leave) && $leave['leave_type'] == 'Emergency') ? 'selected' : '' ?>>
                                    Emergency Leave
                                </option>

                                <option value="Other"
                                    <?= (isset($leave) && $leave['leave_type'] == 'Other') ? 'selected' : '' ?>>
                                    Other
                                </option>

                            </select>
                        </div>
                    </div>

                    <!-- From -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>From Date & Time</label>
                            <input type="datetime-local" name="from_datetime" id="from_datetime" class="form-control"
                                value="<?= isset($leave) ? date('Y-m-d\TH:i', strtotime($leave['from_datetime'])) : '' ?>"
                                required>
                        </div>
                    </div>

                    <!-- To -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>To Date & Time</label>
                            <input type="datetime-local" name="to_datetime" id="to_datetime" class="form-control"
                                value="<?= isset($leave) ? date('Y-m-d\TH:i', strtotime($leave['to_datetime'])) : '' ?>"
                                required>
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Total Duration</label>
                            <input type="text" id="total_days" class="form-control" readonly>
                        </div>
                    </div>

                </div>

                <!-- Reason -->
                <div class="form-group">
                    <label>Reason</label>
                    <textarea name="reason" class="form-control" rows="4"
                        required><?= $leave['reason'] ?? '' ?></textarea>
                </div>

            </div>

            <!-- BUTTON -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <?= isset($leave) ? 'Update Leave' : 'Submit Leave' ?>
                </button>

                <a href="<?= base_url('admin/leave') ?>" class="btn btn-secondary">Back</a>
            </div>

        </form>
    </div>

</div>

<!-- AUTO CALCULATION -->
<script>
function calculateDays() {
    let from = document.getElementById('from_datetime').value;
    let to = document.getElementById('to_datetime').value;

    if (from && to) {
        let fromDate = new Date(from);
        let toDate = new Date(to);

        let diff = toDate - fromDate;

        if (diff >= 0) {

            let totalHours = diff / (1000 * 60 * 60);

            let days = Math.floor(totalHours / 24);
            let hours = Math.floor(totalHours % 24);
            let minutes = Math.floor((totalHours * 60) % 60);

            let result = "";

            if (days > 0) result += days + " day(s) ";
            if (hours > 0) result += hours + " hour(s) ";
            if (minutes > 0) result += minutes + " minute(s)";

            document.getElementById('total_days').value = result.trim();

        } else {
            document.getElementById('total_days').value = "Invalid";
        }
    }
}

document.getElementById('from_datetime').addEventListener('change', calculateDays);
document.getElementById('to_datetime').addEventListener('change', calculateDays);

// Run once on page load (for edit mode)
calculateDays();
</script>

<?= $this->endSection() ?>