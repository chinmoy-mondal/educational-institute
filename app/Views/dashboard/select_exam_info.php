<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4">Generate Tabulation Sheet</h1>

  <div class="card shadow-sm">
    <div class="card-body">
      <form action="<?= site_url('admin/generateTabulation') ?>" method="get">
        <div class="row mb-3">
          <!-- Class -->
          <div class="col-md-3">
            <label for="class" class="form-label">Class</label>
            <select name="class" id="class" class="form-control" required>
              <option value="">Select Class</option>
              <?php foreach ($classes as $c): ?>
                <option value="<?= esc($c['class']) ?>"><?= esc($c['class']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Section -->
          <div class="col-md-3">
            <label for="section" class="form-label">Section</label>
            <select name="section" id="section" class="form-control" required>
              <option value="">Select Section</option>
              <?php foreach ($sections as $s): ?>
                <option value="<?= esc($s['section']) ?>"><?= esc($s['section']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Exam -->
          <div class="col-md-3">
            <label for="exam" class="form-label">Exam</label>
            <select name="exam" id="exam" class="form-control" required>
              <option value="">Select Exam</option>
              <?php foreach ($exams as $e): ?>
                <option value="<?= esc($e['exam']) ?>"><?= esc($e['exam']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Year -->
          <div class="col-md-3">
            <label for="year" class="form-label">Year</label>
            <select name="year" id="year" class="form-control" required>
              <option value="">Select Year</option>
              <?php foreach ($years as $y): ?>
                <option value="<?= esc($y['year']) ?>"><?= esc($y['year']) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-table"></i> Generate Tabulation
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
