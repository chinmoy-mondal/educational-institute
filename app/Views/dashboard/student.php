<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
/* ============================
       PREMIUM PAGINATION STYLE
    =============================== */
.pagination {
    display: flex;
    justify-content: center;
    margin: 25px 0;
}

.pagination .page-item .page-link {
    color: #007bff;
    padding: 8px 14px;
    border-radius: 6px !important;
    margin: 0 4px;
    border: 1px solid #dcdcdc;
    font-weight: 500;
    transition: all 0.25s ease-in-out;
    background: #ffffff;
}

.pagination .page-item .page-link:hover {
    background: #eaf3ff;
    border-color: #007bff;
    color: #0056b3;
}

.pagination .page-item.active .page-link {
    background: #007bff !important;
    border-color: #007bff !important;
    color: #ffffff !important;
    box-shadow: 0px 3px 8px rgba(0, 123, 255, 0.35);
}

.pagination .page-item.disabled .page-link {
    background: #f6f6f6;
    color: #b7b7b7;
    border-color: #e1e1e1;
}
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Student List (<?= esc($total) ?>)</h1>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <form method="get" action="<?= site_url('admin/student') ?>">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label>Search</label>
                            <input type="text" name="q" class="form-control" value="<?= esc($q ?? '') ?>"
                                placeholder="Name, Roll, ID">
                        </div>

                        <div class="col-md-2">
                            <label>Class</label>
                            <select name="class" class="form-control">
                                <option value="">All</option>
                                <?php for ($i = 6; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>" <?= ($class ?? '') == $i ? 'selected' : '' ?>>Class <?= $i ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Section</label>
                            <select name="section" class="form-control">
                                <option value="">All</option>
                                <?php foreach ($sections as $sec): ?>
                                <option value="<?= esc($sec['section']) ?>"
                                    <?= ($section ?? '') === $sec['section'] ? 'selected' : '' ?>>
                                    <?= esc($sec['section']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Religion</label>
                            <select name="religion" class="form-control">
                                <option value="">All</option>
                                <option value="__NULL__" <?= ($religion ?? '') === '__NULL__' ? 'selected' : '' ?>>Not
                                    Set</option>
                                <?php foreach ($religions as $r): ?>
                                <option value="<?= esc($r['religion']) ?>"
                                    <?= ($religion ?? '') === $r['religion'] ? 'selected' : '' ?>>
                                    <?= esc(ucfirst($r['religion'])) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="">All</option>
                                <option value="__NULL__" <?= ($gender ?? '') === '__NULL__' ? 'selected' : '' ?>>Not Set
                                </option>
                                <?php foreach ($genders as $g): ?>
                                <option value="<?= esc($g['gender']) ?>"
                                    <?= ($gender ?? '') === $g['gender'] ? 'selected' : '' ?>>
                                    <?= esc(ucfirst($g['gender'])) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="invisible">btn</label>
                            <button class="btn btn-primary w-100"><i class="fas fa-search"></i> Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Pagination Top -->
        <?php if (!empty($pager)): ?>
        <div class="mt-3">
            <?= $pager->only(['q', 'class', 'section', 'gender', 'religion'])->links('bootstrap') ?>
        </div>
        <?php endif; ?>

        <!-- Student Table -->
        <?php if (!empty($students)): ?>
        <div class="card shadow-sm">
            <div class="card-body table-responsive p-0">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Roll</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Define exams per class
                            $exams_by_class = [
                                6 => ['Half-Yearly', 'Annual Exam'],
                                7 => ['Half-Yearly', 'Annual Exam'],
                                8 => ['Half-Yearly', 'Annual Exam'],
                                9 => ['Half-Yearly', 'Annual Exam'],
                                10 => ['Pre-Test Exam', 'Test Exam'],
                            ];
                            ?>
                        <?php foreach ($students as $s): ?>
                        <tr>
                            <td><?= esc($s['id']) ?></td>
                            <td><?= esc($s['student_name']) ?></td>
                            <td><?= esc($s['roll']) ?></td>
                            <td><?= esc($s['class']) ?></td>
                            <td><?= esc($s['section']) ?></td>
                            <td>
                                <!-- Exam Dropdown -->
                                <?php
                                        $student_class = ($s['class'] ?? 6) - 1;
                                        $exams = $exams_by_class[$student_class] ?? ['Half-Yearly', 'Annual Exam'];
                                        ?>
                                <div class="dropdown d-inline-block me-1">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                        id="examDropdown<?= $s['id'] ?>" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-file-alt"></i> Result
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="examDropdown<?= $s['id'] ?>">
                                        <?php foreach ($exams as $exam): ?>
                                        <li>
                                            <a class="dropdown-item" target="_blank"
                                                href="<?= site_url('admin/test_result') ?>?student_id=<?= $s['id'] ?>&year=2025&exam=<?= urlencode($exam) ?>">
                                                <?= $exam ?>
                                            </a>
                                        </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>

                                <!-- View / Delete Buttons -->
                                <a href="<?= site_url('admin/students/view/' . $s['id']) ?>" class="btn btn-info btn-sm"
                                    target="_blank">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="<?= site_url('admin/students/delete/' . $s['id']) ?>"
                                    class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info mt-4">No students found.</div>
        <?php endif; ?>

        <!-- Pagination Bottom -->
        <?php if (!empty($pager)): ?>
        <div class="mt-3 mb-4">
            <?= $pager->only(['q', 'class', 'section', 'gender', 'religion'])->links('bootstrap') ?>
        </div>
        <?php endif; ?>

    </div>
</div>

<!-- Make sure Bootstrap 5 JS is included for dropdowns -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>