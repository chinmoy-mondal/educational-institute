<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- Top Info Section -->
                    <div class="mb-4 text-center">
                        <h4 class="mb-1">Enter Marks for Students</h4>
                        <p class="mb-0">
                            <strong>Subject:</strong> <?= esc($subject['subject']) ?> &nbsp;|&nbsp;
                            <strong>Class:</strong> <?= esc($subject['class']) ?> &nbsp;|&nbsp;
                            <strong>Section:</strong> <?= esc($subject['section']) ?>
                        </p>
                        <p class="text-muted">
                            <strong>Teacher:</strong> <?= esc($user['name']) ?>
                            <?php if (!empty($user['designation'])): ?>
                                (<?= esc($user['designation']) ?>)
                            <?php endif ?>
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                        <form method="post" action="<?= site_url('results/submit') ?>">
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
<input type="hidden" name="exam" value="Midterm">
<input type="hidden" name="year" value="<?= date('Y') ?>">
<input type="hidden" name="subject_id" value="<?= esc($subject['id']) ?>">
                                        <td>
                                            <?= esc($student['student_name']) ?>
                                            <input type="hidden" name="students[<?= $index ?>][id]" value="<?= esc($student['id']) ?>">
                                        </td>

                                        <td><?= esc($student['roll']) ?></td>
                                        <td><?= esc($student['class']) ?></td>

                                        <td class="mark-cell">
                                            <input type="number" 
                                                name="students[<?= $index ?>][written]" 
                                                class="form-control mark-input text-center" 
                                                style="width: 50px;" 
                                                min="0" max="100" maxlength="3"
                                                oninput="updateTotal(<?= $index ?>)"
                                                onkeydown="moveWithArrow(event)">
                                        </td>

                                        <td class="mark-cell">
                                            <input type="number" 
                                                name="students[<?= $index ?>][mcq]" 
                                                class="form-control mark-input text-center" 
                                                style="width:50px;" 
                                                min="0" max="100" maxlength="3"
                                                oninput="updateTotal(<?= $index ?>)"
                                                onkeydown="moveWithArrow(event)">
                                        </td>

                                        <td class="mark-cell">
                                            <input type="number" 
                                                name="students[<?= $index ?>][practical]" 
                                                class="form-control mark-input text-center" 
                                                style="width: 50px;" 
                                                min="0" max="100" maxlength="3"
                                                oninput="updateTotal(<?= $index ?>)"
                                                onkeydown="moveWithArrow(event)">
                                        </td>

                                        <td>
                                            <input type="number" 
                                                name="students[<?= $index ?>][total]" 
                                                class="form-control bg-light text-center" 
                                                id="total-<?= $index ?>" 
                                                style="width: 100px;" 
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

                    <!-- JS for calculating total and keyboard navigation -->
                    <script>
                        function updateTotal(index) {
                            const written = parseFloat(document.querySelector(`[name="students[${index}][written]"]`).value) || 0;
                            const mcq = parseFloat(document.querySelector(`[name="students[${index}][mcq]"]`).value) || 0;
                            const practical = parseFloat(document.querySelector(`[name="students[${index}][practical]"]`).value) || 0;
                            document.getElementById(`total-${index}`).value = written + mcq + practical;
                        }

                        function moveWithArrow(event) {
                            const key = event.key;
                            const td = event.target.closest('td');
                            if (!td || !td.classList.contains('mark-cell')) return;

                            let targetInput;

                            switch (key) {
                                case "ArrowRight":
                                    let next = td.nextElementSibling;
                                    while (next && !next.classList.contains('mark-cell')) {
                                        next = next.nextElementSibling;
                                    }
                                    targetInput = next?.querySelector('input');
                                    break;

                                case "ArrowLeft":
                                    let prev = td.previousElementSibling;
                                    while (prev && !prev.classList.contains('mark-cell')) {
                                        prev = prev.previousElementSibling;
                                    }
                                    targetInput = prev?.querySelector('input');
                                    break;

                                case "ArrowUp":
                                case "ArrowDown":
                                    const cellIndex = td.cellIndex;
                                    const row = td.closest('tr');
                                    const siblingRow = (key === "ArrowUp")
                                        ? row.previousElementSibling
                                        : row.nextElementSibling;

                                    if (siblingRow && siblingRow.cells[cellIndex]?.classList.contains('mark-cell')) {
                                        targetInput = siblingRow.cells[cellIndex].querySelector('input');
                                    }
                                    break;
                            }

                            if (targetInput) {
                                event.preventDefault();
                                targetInput.focus();
                            }
                        }
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
