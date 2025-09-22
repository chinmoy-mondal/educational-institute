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
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <!-- End Flash Messages -->

        <div class="table-responsive">
          <table id="teacherTable" class="table table-bordered table-hover table-striped align-middle">
            <thead class="bg-navy text-center">
              <tr>
                <th style="width: 60px;">Serial no</th>
                <th style="width: 80px;">Photo</th>
                <th style="width: 200px;">Name</th>
                <th style="width: 100%;">Progress</th>
                <th style="width: 120px;">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td class="text-center"><?= esc($user['position']) ?></td>
                    <td class="text-center">
                      <img src="<?= !empty($user['picture'])
                                  ? $user['picture']
                                  : base_url('public/assets/img/default.png') ?>"
                        width="50" height="50" class="rounded-circle">
                    </td>

                    <td><?= esc($user['name']) ?></td>

                    <td>
                      <div class="progress" style="height: 20px;"> <!-- bigger bar -->
                        <div class="progress-bar bg-success" style="width: 70%;">70%</div>
                      </div>
                    </td>
<td class="text-center">
  <!-- Profile Button -->
  <a href="<?= site_url('profile_id/' . $user['id']) ?>"
     class="btn btn-sm btn-info me-1"
     title="View Profile">
    <i class="fas fa-user"></i>
  </a>

  <!-- Call Button -->
  <a href="tel:<?= esc($user['phone'] ?? '') ?>"
     class="btn btn-sm btn-success me-1"
     title="Call Teacher">
    <i class="fas fa-phone"></i>
  </a>

  <!-- Result View Button -->
  <a href="<?= site_url('teacher_result/' . $user['id']) ?>"
     class="btn btn-sm btn-warning"
     title="View Results">
    <i class="fas fa-chart-bar"></i>
  </a>
</td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="text-center text-muted">No teachers found.</td>
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