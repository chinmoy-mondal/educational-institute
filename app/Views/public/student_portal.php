<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content") ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content">
    <div class="popular-courses py-5">
        <div class="container">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="mb-4">Student Portal</h4>

                    <!-- Search & Filter -->
                    <form method="get" action="<?= site_url('student') ?>" class="row g-2 mb-4">
                        <div class="col-md-4">
                            <input type="text" name="q" class="form-control" placeholder="Search by name, roll or ID" value="<?= esc($q ?? '') ?>">
                        </div>
                        <div class="col-md-3">
				<select name="section" class="form-select">
				  <option value="">All Sections</option>
				  <?php foreach ($sections as $sec): ?>
				    <option value="<?= esc($sec['section']) ?>" <?= ($section ?? '') == $sec['section'] ? 'selected' : '' ?>>
				      <?= esc($sec['section']) ?>
				    </option>
				  <?php endforeach; ?>
				</select>
                        </div>
                        <div class="col-md-3">
                            <select name="section" class="form-select">
                                <option value="">All Sections</option>
                                <?php foreach ($sections as $s): ?>
                                    <option value="<?= esc($s) ?>" <?= ($section ?? '') == $s ? 'selected' : '' ?>><?= esc($s) ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                    </form>

                    <!-- Students Table -->
                    <?php if (!empty($students)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Roll</th>
                                        <th>Class</th>
                                        <th>Section</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $s): ?>
                                        <tr>
                                            <td><?= esc($s['id']) ?></td>
                                            <td><?= esc($s['student_name']) ?></td>
                                            <td><?= esc($s['roll']) ?></td>
                                            <td><?= esc($s['class']) ?></td>
                                            <td><?= esc($s['section']) ?></td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">No students found.</div>
                    <?php endif; ?>

                    <!-- Pagination -->
                    <?php if (!empty($pager)): ?>
                        <div class="mt-4">
                            <?= $pager->only(['q', 'class', 'section'])->links( 'bootstrap') ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include("layouts/base-structure/footer"); ?>
<?= $this->endSection(); ?>
