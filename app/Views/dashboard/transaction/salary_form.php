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
                        <th width="320">Salary Payment</th>
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

                        <!-- 🔽 Salary Form per Teacher -->
                        <td>
                            <form method="post" action="<?= base_url('admin/pay_salary') ?>" class="d-flex gap-2">

                                <?= csrf_field() ?>

                                <input type="hidden" name="teacher_id" value="<?= $t['id'] ?>">

                                <input type="number" name="amount" class="form-control form-control-sm"
                                    placeholder="Amount" required>

                                <input type="month" name="month" class="form-control form-control-sm" required>

                                <button type="submit" class="btn btn-sm btn-success">
                                    Pay
                                </button>

                            </form>
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