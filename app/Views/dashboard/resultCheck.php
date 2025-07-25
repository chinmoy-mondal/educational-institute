<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4"><?= esc($title ?? 'Result Check') ?></h1>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Subject Result Overview</h5>
    </div>
    <div class="card-body">
      <div class="row mb-3">
        <div class="col-md-4">
          <strong>Subject Name:</strong>
          <div class="text-success"><?= esc($subject['subject'] ?? 'N/A') ?></div>
        </div>
        <div class="col-md-4">
          <strong>Teacher:</strong>
          <div class="text-success"><?= esc($users['name'] ?? 'N/A') ?><small>(<?= esc($users['designation'] ?? 'N/A') ?>)</small></div>
        <div class="col-md-4">
          <strong>Subject Code:</strong>
          <div><?= esc($subject['id'] ?? '—') ?></div>
        </div>
      </div>

      <hr>

      <h5 class="mb-3">Student Results</h5>

      <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-secondary">
            <tr>
              <th>Roll</th>
              <th>Name</th>
              <th>Class</th>
              <th>Total Marks</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($results)): ?>
              <?php foreach ($results as $res): ?>
                <tr>
                  <td><strong><?= esc($res['roll']) ?></strong></td>
                  <td><?= esc($res['student_name']) ?></td>
                  <td>Class <?= esc($res['class']) ?> (<?= esc($res['section']) ?>)</td>
                  <td class="text-center text-success"><strong><?= esc($res['total']) ?></strong></td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="text-center text-muted">No result found.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
