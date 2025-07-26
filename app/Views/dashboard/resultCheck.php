<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4"><?= esc($title ?? 'Result Check') ?></h1>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Subject Result Overview</h5>
    </div>
    <div class="card-body">

      <!-- Top Subject Info -->
      <div class="row mb-3 text-center">
        <div class="col-md-4 text-start">
          <strong>Subject Name:</strong>
          <div class="text-success">
            <?= esc($subject['subject'] ?? 'N/A') ?> (ID: <?= esc($subject['id'] ?? '—') ?>)
          </div>
        </div>
        <div class="col-md-4">
          <strong>Teacher:</strong>
          <div class="text-success">
            <?= esc($users['name'] ?? 'N/A') ?><br>
            <small>(<?= esc($users['designation'] ?? 'N/A') ?>)</small>
          </div>
        </div>
        <div class="col-md-4 text-end">
          <strong>Class:</strong>
          <div class="text-success">
            <?= esc($subject['class'] ?? '—') ?>
          </div>
        </div>
      </div>

      <hr>

      <!-- Results Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-secondary">
            <tr>
              <th colspan="3" class="text-center h5 text-primary">Student Results</th>
            </tr>
            <tr>
              <th>Roll</th>
              <th>Name</th>
              <th>Total Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($result)): ?>
              <?php foreach ($result as $res): ?>
                <tr>
                  <td><strong><?= esc($res['roll']) ?></strong></td>
                  <td><?= esc($res['student_name']) ?></td>
                  <td class="text-center text-success"><strong><?= esc($res['total']) ?></strong></td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="3" class="text-center text-muted">No result found.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
