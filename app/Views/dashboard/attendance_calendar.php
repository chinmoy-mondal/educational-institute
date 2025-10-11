<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">

    <h4 class="mb-3">Student Attendance</h4>

    <!-- Filter Form -->
    <form method="post" action="<?= site_url('admin/attendance/calendar') ?>" class="d-flex align-items-center gap-2 mb-3 flex-wrap ps-2">

        <!-- Class Selector -->
        <div class="form-group mb-0">
            <select name="class" id="class" class="form-select form-select-sm" style="height: 34px;">
                <option value="">Select Class</option>
                <?php for ($c = 6; $c <= 10; $c++): ?>
                    <option value="<?= $c ?>" <?= ($selectedClass ?? '') == $c ? 'selected' : '' ?>>Class <?= $c ?></option>
                <?php endfor; ?>
            </select>
        </div>

        <!-- Date Picker -->
        <div class="form-group mb-0">
            <input type="date" name="date" id="date" value="<?= $selectedDate ?? '' ?>" class="form-control form-control-sm" style="height: 34px;">
        </div>

        <!-- Submit Button -->
        <div class="form-group mb-0">
            <button type="submit" class="btn btn-primary btn-sm" style="height: 34px;">
                <i class="fas fa-calendar-alt me-1"></i> Show
            </button>
        </div>

    </form>

    <?php if(!empty($students) && !empty($selectedDate) && !empty($selectedClass)): ?>
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
                <?php foreach($students as $s): 
                    $studentAttendance = isset($attendanceMap[$s['id']]) && is_array($attendanceMap[$s['id']])
                        ? $attendanceMap[$s['id']]
                        : [];
                    $remark = $studentAttendance[$selectedDate] ?? 'A'; // Default Absent
                ?>
                    <tr>
                        <td class="text-center"><?= $selectedClass ?></td>
                        <td class="text-center"><?= $s['roll'] ?></td>
                        <td class="text-start"><?= $s['student_name'] ?></td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm <?= $remark=='P'?'btn-success':'btn-danger' ?>" 
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
function toggleAttendance(btn) {
    const input = btn.nextElementSibling; // hidden input
    let current = btn.innerText;

    // Toggle between P and A
    if(current === 'P') {
        btn.innerText = 'A';
        btn.className = 'btn btn-sm btn-danger';
    } else {
        btn.innerText = 'P';
        btn.className = 'btn btn-sm btn-success';
    }

    input.value = btn.innerText;
}
</script>

<?= $this->endSection() ?>