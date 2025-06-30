<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow border-0 rounded-3">
        <!-- ─── Card Header ─────────────────────────────────────────────────── -->
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <div>
            <h5 class="mb-0">Assigned Subjects</h5>
            <small class="d-block">
              Teacher:&nbsp;<?= esc($user['name']) ?>
              <?php if (!empty($user['designation'])): ?>
                (<?= esc($user['designation']) ?>)
              <?php endif ?>
            </small>
          </div>

        </div>

        <!-- ─── Card Body ──────────────────────────────────────────────────── -->
        <div class="card-body">
          <?php if (!empty($subjects)): ?>
            <div class="table-responsive">
              <table class="table table-bordered table-hover table-striped">
                <thead class="thead-light">
                  <tr>
                    <th style="width:60px">#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Section</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($subjects as $i => $sub): ?>
                    <tr>
                      <td><?= $i + 1 ?></td>
                      <td><?= esc($sub['class']) ?></td>
                      <td><?= esc($sub['subject']) ?></td>
                      <td><?= esc($sub['section']) ?></td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="alert alert-info mb-0">
              No subjects assigned to this user.
            </div>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
