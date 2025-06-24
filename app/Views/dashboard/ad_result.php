<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="mb-4 text-center">Enter Marks for Students</h4>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('message') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('results/submit-demo') ?>">
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
                                            <input type="text" 
                                                name="students[<?= $index ?>][name]" 
                                                class="form-control" 
                                                value="<?= esc($student['student_name']) ?>" readonly>
                                            <input type="hidden" 
                                                name="students[<?= $index ?>][id]" 
                                                value="<?= esc($student['id']) ?>">
                                        </td>

                                        <td>
                                            <input type="text" 
                                                name="students[<?= $index ?>][roll]" 
                                                class="form-control bg-light" 
                                                value="<?= esc($student['roll']) ?>" readonly>
                                        </td>

                                        <td>
                                            <input type="text" 
                                                name="students[<?= $index ?>][class]" 
                                                class="form-control bg-light" 
                                                value="<?= esc($student['class']) ?>" readonly>
                                        </td>

                                        <td>
                                            <input type="number" 
                                                name="students[<?= $index ?>][written]" 
                                                class="form-control mark-input text-center" 
                                                style="width: 100px;" 
                                                min="0" max="100" maxlength="3"
                                                oninput="updateTotal(<?= $index ?>)"
                                                onkeydown="moveWithArrow(event)">
                                        </td>

                                        <td>
                                            <input type="number" 
                                                name="students[<?= $index ?>][mcq]" 
                                                class="form-control mark-input text-center" 
                                                style="width: 100px;" 
                                                min="0" max="100" maxlength="3"
                                                oninput="updateTotal(<?= $index ?>)"
                                                onkeydown="moveWithArrow(event)">
                                        </td>

                                        <td>
                                            <input type="number" 
                                                name="students[<?= $index ?>][practical]" 
                                                class="form-control mark-input text-center" 
                                                style="width: 100px;" 
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
                            if (!td) return;

                            let targetInput;

                            switch (key) {
                                case "ArrowRight":
                                    targetInput = td.nextElementSibling?.querySelector('input');
                                    break;
                                case "ArrowLeft":
                                    targetInput = td.previousElementSibling?.querySelector('input');
                                    break;
                                case "ArrowUp":
                                case "ArrowDown":
                                    const cellIndex = td.cellIndex;
                                    const row = td.closest('tr');
                                    const siblingRow = (key === "ArrowUp")
                                        ? row.previousElementSibling
                                        : row.nextElementSibling;

                                    if (siblingRow) {
                                        targetInput = siblingRow.cells[cellIndex]?.querySelector('input');
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
