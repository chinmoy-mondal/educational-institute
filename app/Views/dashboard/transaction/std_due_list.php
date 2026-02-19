<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <h3 class="fw-bold text-danger mb-4">💰 Student Due List</h3>

    <!-- ================= FILTER CARD ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="get">

                <div class="row">

                    <!-- Month Select -->
                    <div class="col-md-4">
                        <label class="form-label">Select Month</label>
                        <select name="month" class="form-control">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= ($selectedMonth == $m) ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <!-- Section Select -->
                    <div class="col-md-4">
                        <label class="form-label">Select Section</label>
                        <select name="section" class="form-control">
                            <option value="all">All</option>
                            <option value="আবাসিক" <?= ($selectedSection == 'আবাসিক') ? 'selected' : '' ?>>
                                আবাসিক
                            </option>
                            <option value="অনাবাসিক" <?= ($selectedSection == 'অনাবাসিক') ? 'selected' : '' ?>>
                                অনাবাসিক
                            </option>
                        </select>
                    </div>

                    <!-- Filter Button -->
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            🔍 Filter
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <!-- ================= DUE TABLE ================= -->
    <div class="card shadow-sm">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th class="text-danger">Total Fee</th>
                        <th class="text-success">Paid</th>
                        <th class="text-warning">Discount</th>
                        <th class="text-primary">Net Due</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if (!empty($students)) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($students as $std):
                            $section = trim($std['section']);
                            $studentId = $std['id'];

                            $totalFee = $all_month_fees[$selectedMonth][$section]['cumulative'] ?? 0;
                            $paid     = $paymentSummary[$studentId]['paid'] ?? 0;
                            $discount = $paymentSummary[$studentId]['discount'] ?? 0;
                            $netDue   = $totalFee - ($paid + $discount);
                        ?>

                    <tr class="text-center">
                        <td><?= $i++ ?></td>
                        <td class="text-start"><?= esc($std['student_name']) ?></td>
                        <td><?= esc($std['class']) ?></td>
                        <td><?= esc($section) ?></td>

                        <td class="text-danger fw-bold">৳ <?= number_format($totalFee, 2) ?></td>
                        <td class="text-success fw-bold">৳ <?= number_format($paid, 2) ?></td>
                        <td class="text-warning fw-bold">৳ <?= number_format($discount, 2) ?></td>
                        <td class="<?= $netDue > 0 ? 'text-danger' : 'text-success' ?> fw-bold">
                            ৳ <?= number_format($netDue, 2) ?>
                        </td>
                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-danger">
                            No students found
                        </td>
                    </tr>
                    <?php endif; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>