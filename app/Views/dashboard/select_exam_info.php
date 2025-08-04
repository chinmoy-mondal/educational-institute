<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center mt-5">
  <div class="card shadow w-100" style="max-width: 700px;">
    <div class="card-header bg-primary text-white">
      <h3 class="card-title mb-0">Generate Tabulation Sheet</h3>
    </div>

    <div class="card-body">
      <form action="<?= site_url('admin/mark') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
          <label for="class">Class</label>
          <select name="class" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($classes as $c): ?>
              <option value="<?= esc($c['class']) ?>"><?= esc($c['class']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="section">Section</label>
          <select name="section" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($sections as $s): ?>
              <option value="<?= esc($s['section']) ?>"><?= ucfirst(esc($s['section'])) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="exam">Exam</label>
          <select name="exam" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($exams as $e): ?>
              <option value="<?= esc($e['exam']) ?>"><?= esc($e['exam']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label for="year">Year</label>
          <select name="year" class="form-control" required>
            <option value="">Select</option>
            <?php foreach ($years as $y): ?>
              <option value="<?= esc($y['year']) ?>"><?= esc($y['year']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="text-center mt-4">
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-file-alt mr-1"></i> Show Tabulation
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
