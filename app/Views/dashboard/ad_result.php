<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <!-- Profile Card -->
            <div class="card shadow-lg border-0 rounded-4 mb-5">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="<?= base_url('public/images/profile-placeholder.png') ?>" class="rounded-circle" width="120" height="120" alt="Profile Picture">
                        <h3 class="mt-3 mb-0"><?= esc(session('user_name')) ?></h3>
                        <span class="text-muted"><?= esc(session('user_role')) ?></span>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Designation</div>
                        <div class="col-sm-8"><?= esc(session('designation') ?? 'N/A') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Subject</div>
                        <div class="col-sm-8"><?= esc(session('subject') ?? 'N/A') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Gender</div>
                        <div class="col-sm-8"><?= esc(session('gender') ?? 'N/A') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Phone</div>
                        <div class="col-sm-8"><?= esc(session('phone') ?? 'N/A') ?></div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Email</div>
                        <div class="col-sm-8"><?= esc(session('user_email')) ?></div>
                    </div>
                    <div class="text-end">
                        <small class="text-muted">Last updated: <?= esc(session('updated_at') ?? 'Unknown') ?></small>
                    </div>
                </div>
            </div>

            <!-- Result Input Form -->
            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">
                    <h4 class="mb-4 text-center">Enter Student Result</h4>

                    <form method="post" action="<?= site_url('results/submit') ?>">
                        <div class="mb-3">
                            <label for="student_name" class="form-label">Student Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="written" class="form-label">Written Marks</label>
                            <input type="number" class="form-control" id="written" name="written" oninput="calculateTotal()" required>
                        </div>

                        <div class="mb-3">
                            <label for="mcq" class="form-label">MCQ Marks</label>
                            <input type="number" class="form-control" id="mcq" name="mcq" oninput="calculateTotal()" required>
                        </div>

                        <div class="mb-3">
                            <label for="practical" class="form-label">Practical Marks</label>
                            <input type="number" class="form-control" id="practical" name="practical" oninput="calculateTotal()" required>
                        </div>

                        <div class="mb-3">
                            <label for="total" class="form-label">Total Marks</label>
                            <input type="number" class="form-control bg-light" id="total" name="total" readonly>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4">Submit Result</button>
                        </div>
                    </form>

                    <script>
                        function calculateTotal() {
                            const written = parseFloat(document.getElementById('written').value) || 0;
                            const mcq = parseFloat(document.getElementById('mcq').value) || 0;
                            const practical = parseFloat(document.getElementById('practical').value) || 0;
                            const total = written + mcq + practical;
                            document.getElementById('total').value = total;
                        }
                    </script>
                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
