<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i>New Users List</h3>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table id="teacherTable" class="table table-bordered table-hover table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($newUsers)): ?>
                <?php foreach ($newUsers as $user): ?>
                  <tr>
                    <td class="text-center">
                    <img src="<?= base_url('uploads/' . (!empty($user['photo']) ? $teacher['photo'] : 'default.png')) ?>" width="50" height="50" class="rounded-circle"></td>
                    <td><?= esc($user['name']) ?></td>
                    <td><?= esc($user['designation']) ?></td>
                    <td><?= esc($user['subject']) ?></td>
                    <td><?= esc($user['email']) ?></td>
                    <td><?= esc($user['phone']) ?></td>
                    <td class="text-center"><?= esc(ucfirst($user['gender'])) ?></td>
                    <td class="text-center">
		      <a href="<?= base_url('user_permit/' . $user['id']) ?>" class="btn btn-sm btn-info">
		        <i class="fas fa-edit"></i>
		      </a>
                      <a href="<?= base_url('user_delete/' . $user['id']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash-alt"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr><td colspan="8" class="text-center text-muted">No teachers found.</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
