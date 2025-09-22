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
          <table id="teacherTable" class="table table-bordered table-hover table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th>Serial no</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Progress</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr>
                    <td><?= esc($user['position']) ?></td>
                    <td class="text-center">
                      <img src="<?= !empty($user['picture'])
                                  ? $user['picture']
                                  : base_url('public/assets/img/default.png') ?>"
                        width="50" height="50" class="rounded-circle">
                    </td>
                    <td>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-success" style="width: 70%"></div>
                      </div>
                      <small>70%</small>
                    </td>

                    <td><?= esc($user['name']) ?></td>
                    <td class="text-center">
                      <!-- Profile Button -->
                      <a href="<?= site_url('profile_id/' . $user['id']) ?>" class="btn btn-sm btn-info" title="View Profile">
                        <i class="fas fa-user"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted">No teachers found.</td>
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