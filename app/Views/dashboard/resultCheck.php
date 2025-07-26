<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
  <h1 class="mb-4"><?= esc($title ?? 'Result Check') ?></h1>

  <div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
      <h5 class="mb-0">Subject Result Overview</h5>
    </div>
    <div class="card-body">

      <!-- Subject & Teacher Info -->
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


	<div class="text-end mb-3">
	  <a href="<?= site_url('ad-result/' . $users['id'] . '/' . $subject['id']) ?>" class="btn btn-sm btn-warning">
	    <i class="fas fa-edit"></i> Edit Marks
	  </a>
	</div>
      <hr>
      <!-- Results Table -->
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-secondary text-center">
            <tr>
              <th colspan="6" class="h5 text-primary">Student Results</th>
            </tr>
            <tr>
              <th>Roll</th>
              <th>Name</th>
              <th>Written</th>
              <th>MCQ</th>
              <th>Practical</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($result)): ?>
              <?php foreach ($result as $res): ?>
                <tr class="text-center">
                  <td><strong><?= esc($res['roll']) ?></strong></td>
                  <td class="text-start"><?= esc($res['student_name']) ?></td>
                  <td><?= esc($res['written']) ?></td>
                  <td><?= esc($res['mcq']) ?></td>
                  <td><?= esc($res['practical']) ?></td>
                  <td class="text-success fw-bold"><?= esc($res['total']) ?></td>
                </tr>
              <?php endforeach ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center text-muted">No results found.</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </div>

    </div>
  </div>
</div>

<?= $this->endSection() ?>
