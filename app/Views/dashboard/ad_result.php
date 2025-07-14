<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
    .mark-input  { width: 50px; }
    @media (min-width:576px) {
        .mark-input { width: 80px; }
    }

    /* Sticky header for better scrolling */
    .table thead th {
        position: sticky;
        top: 0;
        background-color: #f8f9fa;
        z-index: 2;
    }

    /* Highlight row on focus */
    tr:has(input:focus) {
        background-color: #f1f8ff;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12">
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- Header Info -->
                    <div class="mb-4 text-center">
                        <h4 class="mb-1">Enter Marks for Students</h4>
                        <p class="mb-0">
                            <strong>Subject:</strong> <?= esc($subject['subject']) ?> |
                            <strong>Class:</strong> <?= esc($subject['class']) ?> |
                            <strong>Section:</strong> <?= esc($subject['section']) ?>
                        </p>
                        <p class="text-muted">
                            <strong>Teacher:</strong> <?= esc($user['name']) ?><?php if ($user['designation']): ?> (<?= esc($user['designation']) ?>)<?php endif ?>
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success text-center"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('results/submit') ?>" onsubmit="return validateTotals();">
                        <?= csrf_field() ?>
<div class="mb-3 d-flex justify-content-between align-items-center flex-wrap">
    <div>
        <label for="exam" class="me-2 fw-bold">Select Exam:</label>
        <select name="exam" id="exam" class="form-select d-inline-block w-auto" required>
            <option value="half-yearly">Half Yearly</option>
            <option value="Final">Final</option>
            <option value="Class Test">Class Test</option>
        </select>
    </div>
</div>
                        <input type="hidden" name="year" value="<?= date('Y') ?>">
                        <input type="hidden" name="subject_id" value="<?= esc($subject['id']) ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Roll</th>
                                        <th>Class</th>
                                        <th>Written</th>
                                        <th>MCQ</th>
                                        <th>Practical</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $i => $s): ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td>
                                                <?= esc($s['student_name']) ?>
                                                <input type="hidden" name="students[<?= $i ?>][id]" value="<?= esc($s['id']) ?>">
                                            </td>
                                            <td><?= esc($s['roll']) ?></td>
                                            <td><?= esc($s['class']) ?></td>

                                            <?php foreach (['written','mcq','practical'] as $field): ?>
                                                <td class="mark-cell">
                                                    <input type="number"
                                                           name="students[<?= $i ?>][<?= $field ?>]"
                                                           class="form-control form-control-sm mark-input text-center"
                                                           min="0" max="100"
                                                           oninput="updateTotal(<?= $i ?>)"
                                                           onkeydown="moveWithArrow(event)">
                                                </td>
                                            <?php endforeach; ?>

                                            <td>
                                                <input type="number"
                                                       name="students[<?= $i ?>][total]"
                                                       id="total-<?= $i ?>"
                                                       class="form-control form-control-sm bg-light text-center"
                                                       readonly>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-4">
                            <button class="btn btn-primary px-4"><i class="fas fa-save me-1"></i> Submit Results</button>
                            <button type="button" class="btn btn-secondary px-4 ms-2" onclick="window.print()">
                                <i class="fas fa-print me-1"></i> Print
                            </button>
                        </div>
                    </form>

                    <script>
                        // Live update of total marks
                        function updateTotal(i) {
                            const f = name => parseFloat(document.querySelector(`[name="students[${i}][${name}]"]`).value) || 0;
                            document.getElementById(`total-${i}`).value = f('written') + f('mcq') + f('practical');
                        }

                        // Arrow key navigation between cells
                        function moveWithArrow(e) {
                            const td = e.target.closest('td');
                            if (!td || !td.classList.contains('mark-cell')) return;
                            const dir = { ArrowRight: 1, ArrowLeft: -1 }[e.key];
                            if (dir) {
                                let n = td;
                                do {
                                    n = dir > 0 ? n.nextElementSibling : n.previousElementSibling;
                                } while (n && !n.classList.contains('mark-cell'));
                                if (n) {
                                    e.preventDefault();
                                    n.querySelector('input').focus();
                                }
                            }
                            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                                const row = td.parentElement;
                                const idx = td.cellIndex;
                                const r = e.key === 'ArrowUp' ? row.previousElementSibling : row.nextElementSibling;
                                if (r && r.cells[idx].classList.contains('mark-cell')) {
                                    e.preventDefault();
                                    r.cells[idx].querySelector('input').focus();
                                }
                            }
                        }

                        // Validation to ensure total <= 100
                        function validateTotals() {
                            for (const t of document.querySelectorAll('[id^="total-"]')) {
                                if ((+t.value) > 100) {
                                    alert('Total must be ≤ 100');
                                    t.focus();
                                    return false;
                                }
                            }
                            return true;
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
