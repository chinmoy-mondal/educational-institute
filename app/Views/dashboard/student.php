<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Student List</h1></div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">

    <!-- Search & Filter -->
    <form method="get" action="<?= site_url('admin/students') ?>" class="row g-2 mb-3">
      <div class="col-md-4">
        <input type="text" name="q" class="form-control" placeholder="Search by name, roll or ID" value="<?= esc($q ?? '') ?>">
      </div>
      <div class="col-md-3">
        <select name="class" class="form-select">
          <option value="" <?= ($class ?? '') === '' ? 'selected' : '' ?>>All Classes</option>
          <?php for ($i = 1; $i <= 12; $i++): ?>
            <option value="<?= $i ?>" <?= ($class ?? '') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
          <?php endfor; ?>
        </select>
      </div>
      <div class="col-md-3">
        <select name="section" class="form-select">
          <option value="" <?= ($section ?? '') === '' ? 'selected' : '' ?>>All Sections</option>
          <?php foreach ($sections as $sec): ?>
            <option value="<?= esc($sec['section']) ?>" <?= ($section ?? '') === $sec['section'] ? 'selected' : '' ?>>
              <?= esc($sec['section']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">Search</button>
      </div>
    </form>

    <!-- Student Table -->
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
    <?php endif ?>

    <!-- Pagination -->
    <?php if (!empty($pager)): ?>
      <div class="mt-3">
        <?= $pager->only(['q', 'class', 'section'])->links('bootstrap') ?>
      </div>
    <?php endif ?>

  </div>
</div>

<?= $this->endSection() ?>
