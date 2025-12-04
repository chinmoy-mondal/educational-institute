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
                <th>Exam</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Progress</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $serial = 1; ?>

              <?php if (!empty($joint_data)): ?>
                <?php foreach ($joint_data as $entry): ?>

                  <?php
                    $subjectName = $entry['subject']['subject'] ?? '-';
                    $class       = $entry['subject']['class'] ?? '-';
                    $examName    = $entry['calendar']['subcategory'] ?? '-';
                    $progress    = $entry['progress'] ?? 0;
                  ?>

                  <?php if (!empty($entry['users'])): ?>
                    <?php foreach ($entry['users'] as $user): ?>
                      <tr class="text-center">
                        <td><?= $serial++ ?></td>
                        <td><?= esc($class) ?></td>
                        <td><?= esc($subjectName) ?></td>
                        <td><?= esc($examName) ?></td>

                        <td>
                          <img src="<?= !empty($user['picture']) ? $user['picture'] : base_url('public/assets/img/default.png') ?>"
                          width="50" height="50" class="rounded-circle">
                        </td>

                        <td class="text-start">
                          <?= esc($user['name']) ?>
                        </td>

                        <td>
                          <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success" style="width: <?= $progress ?>%;">
                              <?= $progress ?>%
                            </div>
                          </div>
                        </td>

                        <td>
                          <a href="<?= site_url('profile_id/' . $user['id']) ?>" class="btn btn-sm btn-info me-1">
                            <i class="fas fa-user"></i>
                          </a>

                          <a href="tel:<?= esc($user['phone']) ?>" class="btn btn-sm btn-success me-1">
                            <i class="fas fa-phone"></i>
                          </a>

                          <a href="<?= site_url('teacher_result/' . $user['id']) ?>" class="btn btn-sm btn-warning">
                            <i class="fas fa-chart-bar"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>

                <?php endforeach; ?>

              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted">No teacher marking data found.</td>
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