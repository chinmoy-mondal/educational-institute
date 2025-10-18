<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Set Fees Amount</h4>
        </div>

        <div class="card-body">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php elseif (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="<?= base_url('admin/save_fees_amount') ?>" method="post" id="feesForm">
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
                </div>

                <!-- ✅ Fees Table -->
                <?php if ($selectedClass): ?>
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Fee Title</th>
                                <th width="200">Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($fees as $f): ?>
                                <tr>
                                    <td><?= esc($f['title']) ?></td>
                                    <td>
                                        <input type="number" step="0.01" name="fees[<?= $f['id'] ?>]"
                                            value="<?= esc($existingAmounts[$f['id']] ?? '') ?>"
                                            class="form-control" placeholder="Enter amount">
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Please select a class to view and set fees.</p>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Auto reload form when class changes -->
<script>
function reloadFees() {
    const cls = document.getElementById('classSelect').value;
    if (cls) {
        window.location.href = "<?= base_url('admin/set_fees') ?>?class=" + cls;
    }
}
</script>

<?= $this->endSection() ?>