<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i> Teacher List</h3>
      </div>

      <div class="card-body">

        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
        <?php endif; ?>
        <!-- End Flash Messages -->

        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th style="width: 40px;">S/N</th>
                <th style="width: 10%;">Class</th>
                <th style="width: 20%;">Subject</th>
                <th style="width: 80px;">Photo</th>
                <th style="width: 20%;">Name</th>
                <th style="width: 30%;">Progress</th>
                <th style="width: 15%;">Action</th>
              </tr>
            </thead>

            <tbody>
              <?php $serial = 1; ?>

              <?php if (!empty($joint_data)): ?>

                <?php foreach ($joint_data as $entry): ?>

                  <?php
                  $subjectName = $entry['subject']['subject'] ?? '-';
                  $class = $entry['subject']['class'] ?? '-';
                  $fullMark = $entry['subject']['full_mark'] ?? 100;
                  ?>

                  <?php if (!empty($entry['users'])): ?>
                    <?php foreach ($entry['users'] as $user): ?>

                      <?php
                      // Filter results only for THIS TEACHER
                      $teacherResults = array_filter(
                        $entry['results'],
                        function ($r) use ($user) {
                          return $r['teacher_id'] == $user['id'];
                        }
                      );

                      $totalStudents = count($teacherResults);

                      // Sum marks only for this teacher
                      $sumMarks = array_sum(array_map(function ($r) {
                        return $r['total'] ?? 0;
                      }, $teacherResults));

                      $maxPossibleTotal = $totalStudents * $fullMark;

                      $progressPercentage = $maxPossibleTotal > 0
                        ? round(($sumMarks / $maxPossibleTotal) * 100)
                        : 0;
                      ?>

                      <tr class="text-center">
                        <td><?= $serial++ ?></td>

                        <td><?= esc($class) ?></td>

                        <td><?= esc($subjectName) ?></td>

                        <td>
                          <img src="<?= !empty($user['picture'])
                                      ? $user['picture']
                                      : base_url('public/assets/img/default.png') ?>"
                            width="50" height="50" class="rounded-circle">
                        </td>

                        <td class="text-start"><?= esc($user['name']) ?></td>

                        <td>
                          <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-success"
                              style="width: <?= $progressPercentage ?>%;">
                              <?= $progressPercentage ?>%
                            </div>
                          </div>
                        </td>

                        <td>
                          <a href="<?= site_url('profile_id/' . $user['id']) ?>"
                            class="btn btn-sm btn-info me-1">
                            <i class="fas fa-user"></i>
                          </a>

                          <a href="tel:<?= esc($user['phone'] ?? '') ?>"
                            class="btn btn-sm btn-success me-1">
                            <i class="fas fa-phone"></i>
                          </a>

                          <a href="<?= site_url('teacher_result/' . $user['id']) ?>"
                            class="btn btn-sm btn-warning">
                            <i class="fas fa-chart-bar"></i>
                          </a>
                        </td>
                      </tr>

                    <?php endforeach; ?>

                  <?php else: ?>
                    <tr>
                      <td colspan="7" class="text-center text-muted">No teachers found for this subject.</td>
                    </tr>
                  <?php endif; ?>

                <?php endforeach; ?>

              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">No exam data found.</td>
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