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
                    <th class="text-start">Name / Roll</th>
                    <th><?= date('d M Y', strtotime($selectedDate)) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $s): 
                    $remark = $attendanceMap[$s['id']][$selectedDate] ?? '';
                ?>
                    <tr>
                        <td class="text-start"><?= $s['student_name'] ?> (<?= $s['roll'] ?>)</td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-sm <?= $remark=='P'?'btn-success':($remark=='A'?'btn-danger':($remark=='L'?'btn-warning':'btn-outline-secondary')) ?>" 
                                    onclick="toggleAttendance(this)">
                                <?= $remark ?: '-' ?>
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

    // Cycle: empty -> P -> A -> L -> empty
    if(current === '' || current === '-') {
        btn.innerText = 'P';
        btn.className = 'btn btn-sm btn-success';
    } else if(current === 'P') {
        btn.innerText = 'A';
        btn.className = 'btn btn-sm btn-danger';
    } else if(current === 'A') {
        btn.innerText = 'L';
        btn.className = 'btn btn-sm btn-warning';
    } else if(current === 'L') {
        btn.innerText = '-';
        btn.className = 'btn btn-sm btn-outline-secondary';
    }

    input.value = btn.innerText === '-' ? '' : btn.innerText;
}
</script>

<?= $this->endSection() ?>