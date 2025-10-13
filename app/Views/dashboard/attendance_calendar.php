<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <h4 class="mb-3">Student Attendance</h4>

    <!-- ✅ Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- ✅ Filter Form -->
    <form action="<?= base_url('admin/attendance/calendar') ?>" method="post" class="d-flex flex-wrap align-items-center gap-3 mb-3">

        <!-- Class Select -->
        <div>
            <label for="class" class="form-label mb-1">Class</label>
            <select name="class" id="class" class="form-select">
                <option value="">Select Class</option>
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <option value="<?= $i ?>">Class <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Date Input -->
        <div>
            <label for="date" class="form-label mb-1">Date</label>
            <input type="date" name="date" id="date" class="form-control">
        </div>

        <!-- Show Button -->
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Show</button>
        </div>

        <!-- All Present Button -->
        <div class="mt-4">
            <button type="button" class="btn btn-success">All Present</button>
        </div>
    </form>

    <?php if (!empty($students) && !empty($selectedDate) && !empty($selectedClass)): ?>
        <!-- Attendance Table Form -->
        <form method="post" action="<?= site_url('admin/attendance/save') ?>">
            <input type="hidden" name="class" value="<?= $selectedClass ?>">
            <input type="hidden" name="date" value="<?= $selectedDate ?>">

            <table class="table table-bordered table-sm">
                <thead class="table-light text-center">
                    <tr>
                        <th>Class</th>
                        <th>Roll</th>
                        <th class="text-start">Name</th>
                        <th><?= date('d M Y', strtotime($selectedDate)) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $s):
                        $remarks = $attendanceMap[$s['id']] ?? [];
                        $remark = (in_array('A', $remarks) && in_array('L', $remarks)) ? 'P' : 'A';
                    ?>
                        <tr>
                            <td class="text-center"><?= $selectedClass ?></td>
                            <td class="text-center"><?= $s['roll'] ?></td>
                            <td class="text-start"><?= $s['student_name'] ?></td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-sm <?= $remark == 'P' ? 'btn-success' : 'btn-danger' ?> attendance-btn"
                                    onclick="toggleAttendance(this)">
                                    <?= $remark ?>
                                </button>
                                <input type="hidden" name="attendance[<?= $s['id'] ?>][<?= $selectedDate ?>]" value="<?= $remark ?>">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <button type="submit" class="btn btn-success btn-sm mt-2">Submit Attendance</button>
        </form>
    <?php else: ?>
        <p class="text-muted">Select class and date to show attendance.</p>
    <?php endif; ?>

</div>

<script>
    // ✅ Toggle single student attendance
    function toggleAttendance(btn) {
        const input = btn.nextElementSibling;
        const current = btn.innerText.trim();

        if (current === 'P') {
            btn.innerText = 'A';
            btn.className = 'btn btn-sm btn-danger attendance-btn';
        } else {
            btn.innerText = 'P';
            btn.className = 'btn btn-sm btn-success attendance-btn';
        }

        input.value = btn.innerText;
    }

    // ✅ Set all attendance to Present or Absent
    function setAllAttendance(status) {
        document.querySelectorAll('.attendance-btn').forEach(btn => {
            const input = btn.nextElementSibling;
            btn.innerText = status;

            if (status === 'P') {
                btn.className = 'btn btn-sm btn-success attendance-btn';
            } else {
                btn.className = 'btn btn-sm btn-danger attendance-btn';
            }

            input.value = status;
        });
    }
</script>

<?= $this->endSection() ?>