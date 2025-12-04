<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i> Teacher List</h3>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th>S/N</th>
                <th>Class</th>
                <th>Subject</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Progress</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $serial = 1; ?>
              <?php if(!empty($joint_data)): ?>
                <?php foreach($joint_data as $entry): ?>
                  <tr class="text-center">
                    <td><?= $serial++ ?></td>
                    <td><?= esc($entry['subject']['class']) ?></td>
                    <td><?= esc($entry['subject']['subject']) ?></td>
                    <td>
                      <img src="<?= !empty($entry['teacher']['picture']) ? $entry['teacher']['picture'] : base_url('public/assets/img/default.png') ?>"
                           width="50" height="50" class="rounded-circle">
                    </td>
                    <td class="text-start"><?= esc($entry['teacher']['name']) ?></td>
                    <td>
                      <div class="progress" style="height: 20px;">
                        <div class="progress-bar <?= $entry['progress'] == 100 ? 'bg-success' : 'bg-warning' ?>" style="width: <?= $entry['progress'] ?>%;">
                          <?= $entry['marks_entered'] ?> / <?= $entry['total_rows'] ?>
                        </div>
                      </div>
                    </td>
                    <td>
                      <a href="<?= site_url('profile_id/' . $entry['teacher']['id']) ?>" class="btn btn-sm btn-info me-1" title="View Profile">
                        <i class="fas fa-user"></i>
                      </a>
                      <a href="tel:<?= esc($entry['teacher']['phone'] ?? '') ?>" class="btn btn-sm btn-success me-1" title="Call Teacher">
                        <i class="fas fa-phone"></i>
                      </a>
                      <a href="<?= site_url('teacher_result/' . $entry['teacher']['id']) ?>" class="btn btn-sm btn-warning" title="View Results">
                        <i class="fas fa-chart-bar"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">No data found</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>