<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- ─── Top Info ─────────────────────────────────────── -->
                    <div class="mb-4 text-center">
                        <h4 class="mb-1">Enter Marks for Students</h4>
                        <p class="mb-0">
                            <strong>Subject:</strong> <?= esc($subject['subject']) ?> |
                            <strong>Class:</strong> <?= esc($subject['class']) ?> |
                            <strong>Section:</strong> <?= esc($subject['section']) ?>
                        </p>
                        <p class="text-muted">
                            <strong>Teacher:</strong> <?= esc($user['name']) ?>
                            <?php if (!empty($user['designation'])): ?>
                                (<?= esc($user['designation']) ?>)
                            <?php endif ?>
                        </p>
                    </div>

                    <!-- Flash message -->
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <!-- ─── Form ────────────────────────────────────────── -->
                    <form method="post" action="<?= site_url('results/submit') ?>">

                        <!-- Hidden context -->
                        <input type="hidden" name="exam" value="Midterm">
                        <input type="hidden" name="year" value="<?= date('Y') ?>">
                        <input type="hidden" name="subject_id" value="<?= esc($subject['id']) ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
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
                                    <?php foreach ($students as $index => $student): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>

                                        <td>
                                            <?= esc($student['student_name']) ?>
                                            <input type="hidden"
                                                   name="students[<?= $index ?>][id]"
                                                   value="<?= esc($student['id']) ?>">
                                        </td>

                                        <td><?= esc($student['roll']) ?></td>
                                        <td><?= esc($student['class']) ?></td>

                                        <!-- Written -->
                                        <td class="mark-cell">
                                            <input type="number"
                                                   name="students[<?= $index ?>][written]"
                                                   class="form-control mark-input text-center"
                                                   style="width:50px"
                                                   min="0" max="100"
                                                   oninput="updateTotal(<?= $index ?>)"
                                                   onkeydown="moveWithArrow(event)">
                                        </td>

                                        <!-- MCQ -->
                                        <td class="mark-cell">
                                            <input type="number"
                                                   name="students[<?= $index ?>][mcq]"
                                                   class="form-control mark-input text-center"
                                                   style="width:50px"
                                                   min="0" max="100"
                                                   oninput="updateTotal(<?= $index ?>)"
                                                   onkeydown="moveWithArrow(event)">
                                        </td>

                                        <!-- Practical -->
                                        <td class="mark-cell">
                                            <input type="number"
                                                   name="students[<?= $index ?>][practical]"
                                                   class="form-control mark-input text-center"
                                                   style="width:50px"
                                                   min="0" max="100"
                                                   oninput="updateTotal(<?= $index ?>)"
                                                   onkeydown="moveWithArrow(event)">
                                        </td>

                                        <!-- Total -->
                                        <td>
                                            <input type="number"
                                                   name="students[<?= $index ?>][total]"
                                                   class="form-control bg-light text-center"
                                                   id="total-<?= $index ?>"
                                                   style="width:100px"
                                                   max="100"
                                                   readonly>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Submit Results</button>
                        </div>
                    </form>

                    <!-- ─── Scripts ─────────────────────────────────────── -->
                    <script>
                        /* live total */
                        function updateTotal(i) {
                            const w = parseFloat(document.querySelector(`[name="students[${i}][written]"]`).value) || 0;
                            const m = parseFloat(document.querySelector(`[name="students[${i}][mcq]"]`).value) || 0;
                            const p = parseFloat(document.querySelector(`[name="students[${i}][practical]"]`).value) || 0;
                            document.getElementById(`total-${i}`).value = w + m + p;
                        }

                        /* arrow-key navigation */
                        function moveWithArrow(e) {
                            const td = e.target.closest('td');
                            if (!td || !td.classList.contains('mark-cell')) return;

                            let target;
                            switch (e.key) {
                                case "ArrowRight":
                                    let next = td.nextElementSibling;
                                    while (next && !next.classList.contains('mark-cell')) next = next.nextElementSibling;
                                    target = next?.querySelector('input'); break;
                                case "ArrowLeft":
                                    let prev = td.previousElementSibling;
                                    while (prev && !prev.classList.contains('mark-cell')) prev = prev.previousElementSibling;
                                    target = prev?.querySelector('input'); break;
                                case "ArrowUp":
                                case "ArrowDown":
                                    const idx = td.cellIndex;
                                    const row = td.closest('tr');
                                    const sib = (e.key === "ArrowUp") ? row.previousElementSibling : row.nextElementSibling;
                                    if (sib && sib.cells[idx]?.classList.contains('mark-cell'))
                                        target = sib.cells[idx].querySelector('input');
                                    break;
                            }
                            if (target) { e.preventDefault(); target.focus(); }
                        }

                        /* block submit if any total > 100 */
                        document.querySelector('form').addEventListener('submit', function (e) {
                            const totals = document.querySelectorAll('[id^="total-"]');
                            for (const input of totals) {
                                if ((parseFloat(input.value) || 0) > 100) {
                                    alert('Total marks cannot exceed 100.');
                                    input.focus();
                                    e.preventDefault();
                                    return false;
                                }
                            }
                        });
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
