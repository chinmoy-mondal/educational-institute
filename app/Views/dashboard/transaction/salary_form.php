<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-3">Teacher Salary List</h4>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Subject</th>
                        <th>Phone</th>
                        <th width="420">Salary Payment</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($teachers)): ?>
                    <?php foreach ($teachers as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($t['name']) ?></td>
                        <td><?= esc($t['designation']) ?></td>
                        <td><?= esc($t['subject']) ?></td>
                        <td><?= esc($t['phone']) ?></td>

                        <!-- 🔽 Salary Form / Permission Check -->
                        <td>
                            <?php if (!empty($canPaySalary) && $canPaySalary): ?>
                            <form method="post" action="<?= base_url('admin/pay_salary') ?>" class="d-flex gap-2">
                                <?= csrf_field() ?>
                                <input type="hidden" name="teacher_id" value="<?= $t['id'] ?>">

                                <!-- Amount -->
                                <input type="number" name="amount" class="form-control form-control-sm"
                                    placeholder="Amount" required>

                                <!-- Month Dropdown (only month, no year) -->
                                <select name="month" class="form-control form-control-sm" required>
                                    <option value="">Select Month</option>
                                    <?php
                                                $months = [
                                        '1' => 'January',
                                        '2' => 'February',
                                        '3' => 'March',
                                        '4' => 'April',
                                        '5' => 'May',
                                        '6' => 'June',
                                        '7' => 'July',
                                        '8' => 'August',
                                        '9' => 'September',
                                                    '10' => 'October',
                                                    '11' => 'November',
                                                    '12' => 'December',
                                                ];
                                                foreach ($months as $num => $name):
                                                ?>
                                    <option value="<?= $num ?>"><?= $name ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <!-- Section -->
                                <select name="section" class="form-control form-control-sm" required>
                                    <option value="">Select Section</option>
                                    <?php if (!empty($sections)): ?>
                                    <?php foreach ($sections as $sec): ?>
                                    <option value="<?= esc($sec['section']) ?>"><?= esc($sec['section']) ?></option>
                                    <?php endforeach ?>
                                    <?php endif; ?>
                                </select>

                                <!-- Submit -->
                                <button type="submit" class="btn btn-sm btn-success">Pay</button>
                            </form>
                            <?php else: ?>
                            <span class="badge bg-danger">You are not allowed</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No teachers found
                        </td>
                    </tr>
                    <?php endif ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>