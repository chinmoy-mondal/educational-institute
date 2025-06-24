<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="mb-4 text-center">Enter Marks for 10 Demo Students</h4>

                    <form method="post" action="<?= site_url('results/submit-demo') ?>">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student Name</th>
                                        <th>Written</th>
                                        <th>MCQ</th>
                                        <th>Practical</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $demoNames = [
                                            "Ayesha Akter", "Sakib Hasan", "Nusrat Jahan", "Fahim Ahmed", "Tanjim Alam",
                                            "Jannatul Ferdous", "Imran Hossain", "Mim Sultana", "Raihan Islam", "Shorna Akter"
                                        ];
                                        foreach ($demoNames as $index => $name):
                                    ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <input type="text" name="students[<?= $index ?>][name]" class="form-control" value="<?= $name ?>" readonly>
                                        </td>
                                        <td>
                                            <input type="number" name="students[<?= $index ?>][written]" class="form-control mark-input" oninput="updateTotal(<?= $index ?>)">
                                        </td>
                                        <td>
                                            <input type="number" name="students[<?= $index ?>][mcq]" class="form-control mark-input" oninput="updateTotal(<?= $index ?>)">
                                        </td>
                                        <td>
                                            <input type="number" name="students[<?= $index ?>][practical]" class="form-control mark-input" oninput="updateTotal(<?= $index ?>)">
                                        </td>
                                        <td>
                                            <input type="number" name="students[<?= $index ?>][total]" class="form-control bg-light" readonly id="total-<?= $index ?>">
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end">
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
                    </script>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
