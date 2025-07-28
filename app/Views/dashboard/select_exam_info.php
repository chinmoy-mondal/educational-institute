<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4">Generate Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-body">
    <form action="<?= site_url('admin/mark') ?>" method="post">
  <?= csrf_field() ?>

  <div class="row">
    <!-- Class -->
    <div class="col-md-3">
      <label for="class">Class</label>
      <select name="class" class="form-control" required>
        <option value="">Select</option>
        <?php foreach ($classes as $c): ?>
          <option value="<?= esc($c['class']) ?>"><?= esc($c['class']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Section -->
    <div class="col-md-3">
      <label for="section">Section</label>
      <select name="section" class="form-control" required>
        <option value="">Select</option>
        <?php foreach ($sections as $s): ?>
          <option value="<?= esc($s['section']) ?>"><?= esc($s['section']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Exam -->
    <div class="col-md-3">
      <label for="exam">Exam</label>
      <select name="exam" class="form-control" required>
        <option value="">Select</option>
        <?php foreach ($exams as $e): ?>
          <option value="<?= esc($e['exam']) ?>"><?= esc($e['exam']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Year -->
    <div class="col-md-3">
      <label for="year">Year</label>
      <select name="year" class="form-control" required>
        <option value="">Select</option>
        <?php foreach ($years as $y): ?>
          <option value="<?= esc($y['year']) ?>"><?= esc($y['year']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="text-center mt-3">
    <button type="submit" class="btn btn-primary">Show Tabulation</button>
  </div>
</form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
