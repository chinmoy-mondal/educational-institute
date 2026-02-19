<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

    <h3 class="fw-bold text-danger mb-4">
        💰 Student Due List (Cumulative up to <?= date('F', mktime(0, 0, 0, $selectedMonth, 1)) ?>)
    </h3>

    <!-- ================= FILTER CARD ================= -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="get" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Select Month</label>
                    <select name="month" class="form-control">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($selectedMonth == $m) ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Select Section</label>
                    <select name="section" class="form-control">
                        <option value="all" <?= ($selectedSection == 'all') ? 'selected' : '' ?>>All</option>
                        <option value="আবাসিক" <?= ($selectedSection == 'আবাসিক') ? 'selected' : '' ?>>আবাসিক</option>
                        <option value="অনাবাসিক" <?= ($selectedSection == 'অনাবাসিক') ? 'selected' : '' ?>>অনাবাসিক
                        </option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Show Type</label>
                    <select name="due_type" class="form-control">
                        <option value="all" <?= ($dueType == 'all') ? 'selected' : '' ?>>All Students</option>
                        <option value="due" <?= ($dueType == 'due') ? 'selected' : '' ?>>Only Due</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">🔍 Filter</button>
                </div>

            </form>
        </div>
    </div>

    <!-- ================= DUE TABLE ================= -->
    <div class="card shadow-sm">
        <!-- Download Button -->
        <div class="card-header d-flex justify-content-end">
            <a href="<?= base_url('admin/std_due_csv?month=' . $selectedMonth . '&section=' . $selectedSection . '&due_type=' . ($dueType ?? 'due')) ?>"
                class="btn btn-success">
                ⬇ Download CSV
            </a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Student ID</th>
                        <th>Student Name</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Total Fee</th>
                        <th>Paid</th>
                        <th>Discount</th>
                        <th>Get</th>
                        <th>Net Due</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($students)): $i = 1; ?>
                    <?php foreach ($students as $std):
                            $sid = $std['id'];
                            $sec = trim($std['section']);

                            $totalFee = $monthFees[$sec] ?? 0;
                            $paid = $paymentSummary[$sid]['paid'] ?? 0;
                            $discount = $paymentSummary[$sid]['discount'] ?? 0;
                            $get = $paid - $discount;
                            $netDue = $totalFee - $paid;

                            if ($dueType == 'due' && $netDue <= 0) {
                                continue;
                            }
                        ?>
                    <tr class="text-center">
                        <td><?= $i++ ?></td>
                        <td><?= esc($sid) ?></td>
                        <td class="text-start"><?= esc($std['student_name']) ?></td>
                        <td class="text-start">
                            <a href="tel:<?= esc($std['phone']) ?>">
                                <?= esc($std['phone']) ?>
                            </a>
                        </td>
                        <td><?= esc($std['class']) ?></td>
                        <td><?= esc($sec) ?></td>
                        <td class="text-danger fw-bold">৳ <?= number_format($totalFee, 2) ?></td>
                        <td class="text-muted fw-bold">৳ <?= number_format($paid, 2) ?></td>
                        <td class="text-warning fw-bold">৳ <?= number_format($discount, 2) ?></td>
                        <td class="text-success fw-bold">৳ <?= number_format($get, 2) ?></td>
                        <td class="<?= $netDue > 0 ? 'text-danger' : 'text-success' ?> fw-bold">৳
                            <?= number_format($netDue, 2) ?></td>
                        <td>
                            <a href="<?= base_url('admin/studentPaymentHistory/' . esc($sid)) ?>"
                                class="btn btn-sm btn-info" target="_blank">
                                <i class="fas fa-history"></i> History
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center text-danger">No students found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<?= $this->endSection() ?>