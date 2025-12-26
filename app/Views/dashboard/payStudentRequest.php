<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Student Payment Request</h4>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <strong>Student Payment Form</strong>
        </div>

        <div class="card-body">
            <form method="post" action="<?= base_url('admin/submitStudentPayment') ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="student_id" value="<?= esc($student['id']) ?>">
                <input type="hidden" name="receiver_id" value="<?= esc($receiver['id']) ?>">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Student Name</label>
                        <input type="text" class="form-control" value="<?= esc($student['student_name']) ?>" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Class</label>
                        <input type="text" class="form-control" value="Class <?= esc($student['class']) ?>" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Receiver</label>
                        <input type="text" class="form-control" value="<?= esc($receiver['name']) ?>" readonly>
                    </div>
                </div>

                <div class="table-responsive mb-3">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>SL</th>
                                <th>Fee Title</th>
                                <th>Max Amount (৳)</th>
                                <th>Month</th>
                                <th>Pay Amount (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            $months = [
                                '01' => 'January',
                                '02' => 'February',
                                '03' => 'March',
                                '04' => 'April',
                                '05' => 'May',
                                '06' => 'June',
                                '07' => 'July',
                                '08' => 'August',
                                '09' => 'September',
                                '10' => 'October',
                                '11' => 'November',
                                '12' => 'December'
                            ];
                            ?>
                            <?php foreach ($fees as $f):
                                $unit = $feeUnit[$f['id']] ?? 0;
                                $amount = $feeAmounts[$f['id']] ?? 0;
                                $max = $unit * $amount;
                            ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><?= esc($f['title']) ?></td>
                                <td>
                                    <?= $unit && $amount ? $unit . ' × ' . $amount : '-' ?>
                                </td>
                                <td>
                                    <select name="month[]" class="form-select form-select-sm" required>
                                        <option value="">-- Select Month --</option>
                                        <?php foreach ($months as $key => $label): ?>
                                        <option value="<?= $key ?>"><?= $label ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="fee_id[]" value="<?= esc($f['id']) ?>">
                                    <input type="number" step="0.01" name="amount[]"
                                        class="form-control form-control-sm" placeholder="Enter amount"
                                        max="<?= $max ?>">
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane"></i> Submit Payment Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>