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
                <th>Photo</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Subject</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Position</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                  <tr>

                    <td class="text-center">
                      <img src="<?= !empty($user['picture'])
                                  ? $user['picture']
                                  : base_url('public/assets/img/default.png') ?>"
                        width="50" height="50" class="rounded-circle">
                    </td>

                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['designation']) ?></td>
                    <td><?= esc($user['subject']) ?></td>
                    <td><?= esc($user['phone']) ?></td>
                    <td class="text-center"><?= esc(ucfirst($user['gender'])) ?></td>
                    <td class="text-center">
                      <form action="<?= base_url('admin/updatePosition/' . esc($user['id'])) ?>" method="post" class="d-flex align-items-center">
                        <select name="position" id="position" class="form-control me-1" style="width:auto; min-width:70px;" required>
                          <option value="0" disabled selected>Position</option>
                          <?php for ($i = 1; $i <= $total_users; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?></option>
                          <?php endfor; ?>
                        </select> &nbsp;
                        <button type="submit" class="btn btn-primary btn-sm">Save</button>
                      </form>
                    </td>
                    <td class="text-center">
                      <!-- Profile Button -->
                      <a href="<?= site_url('profile_id/' . $user['id']) ?>" class="btn btn-sm btn-info" title="View Profile">
                        <i class="fas fa-user"></i>
                      </a>

                      <!-- Restrict Button -->
                      <a href="<?= base_url('restrict/' . $user['id']) ?>"
                        onclick="return confirm('Are you sure you want to restrict this user?')"
                        class="btn btn-sm btn-warning" title="Restrict User">
                        <i class="fas fa-user-slash"></i>
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