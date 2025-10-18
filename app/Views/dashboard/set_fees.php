<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Set Fees Amount</h4>
        </div>

        <div class="card-body">
            <!-- ✅ Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('admin/save_fees') ?>" method="post" id="feesForm">
                <?= csrf_field() ?>

                <!-- ✅ Class Selector inside the same form -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Select Class:</label>
                        <select name="class" id="classSelect" class="form-select" required onchange="reloadFees()">
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $cls): ?>
                                <option value="<?= $cls ?>" <?= ($selectedClass == $cls ? 'selected' : '') ?>>
                                    Class <?= $cls ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <?php if (!empty($lastUpdated)): ?>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0">
                            <span class="badge bg-info text-dark p-2">
                                Last Updated: <?= esc(date('d M, Y h:i A', strtotime($lastUpdated))) ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- ✅ Fees Table -->
                <?php if ($selectedClass): ?>
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th width="60">SL</th>
                                <th>Fee Title</th>
                                <th width="200">Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]"
                                            value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                                            class="form-control fee-input"
                                            placeholder="Enter amount">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success px-4">Save</button>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Please select a class to set fees.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<!-- ✅ JavaScript for reload and arrow navigation -->
<script>
function reloadFees() {
    const cls = document.getElementById('classSelect').value;
    if (cls) {
        window.location.href = "<?= base_url('admin/set_fees') ?>?class=" + cls;
    }
}

// ✅ Move between inputs using ↑ ↓ arrow keys
document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.fee-input');

    inputs.forEach((input, index) => {
        input.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const next = inputs[index + 1];
                if (next) next.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                const prev = inputs[index - 1];
                if (prev) prev.focus();
            }
        });
    });
});
</script>

<?= $this->endSection() ?>