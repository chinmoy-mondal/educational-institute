<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Result Entry Form -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="mb-4 text-center">Enter Marks for All Students</h4>

                    <form method="post" action="<?= site_url('results/submit-all') ?>" id="resultForm">
                        <div id="students-container">
                            <!-- Student Row Template -->
                            <div class="student-row row g-3 mb-4 border rounded p-3 position-relative">
                                <div class="col-md-4">
                                    <label class="form-label">Student Name</label>
                                    <input type="text" name="students[0][name]" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Written</label>
                                    <input type="number" name="students[0][written]" class="form-control mark-input" oninput="updateTotal(this)" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">MCQ</label>
                                    <input type="number" name="students[0][mcq]" class="form-control mark-input" oninput="updateTotal(this)" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Practical</label>
                                    <input type="number" name="students[0][practical]" class="form-control mark-input" oninput="updateTotal(this)" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Total</label>
                                    <input type="number" name="students[0][total]" class="form-control bg-light" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 text-end">
                            <button type="button" class="btn btn-outline-success" onclick="addStudentRow()">+ Add Student</button>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Submit All Results</button>
                        </div>
                    </form>

                    <script>
                        let studentIndex = 1;

                        function updateTotal(input) {
                            const row = input.closest('.student-row');
                            const written = parseFloat(row.querySelector('input[name$="[written]"]').value) || 0;
                            const mcq = parseFloat(row.querySelector('input[name$="[mcq]"]').value) || 0;
                            const practical = parseFloat(row.querySelector('input[name$="[practical]"]').value) || 0;
                            const totalInput = row.querySelector('input[name$="[total]"]');
                            totalInput.value = written + mcq + practical;
                        }

                        function addStudentRow() {
                            const container = document.getElementById('students-container');
                            const rows = container.querySelectorAll('.student-row');
                            const newRow = rows[0].cloneNode(true);

                            // Clear inputs and update names
                            newRow.querySelectorAll('input').forEach(input => {
                                const name = input.name.replace(/\[\d+\]/, `[${studentIndex}]`);
                                input.name = name;
                                input.value = '';
                            });

                            container.appendChild(newRow);
                            studentIndex++;
                        }
                    </script>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
