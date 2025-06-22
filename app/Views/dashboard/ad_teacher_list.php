<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i> Teacher List</h3>
        <a href="<?= base_url('teacher/create') ?>" class="btn btn-sm btn-primary">
          <i class="fas fa-plus"></i> Add Teacher
        </a>
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
              <?php if (!empty($teachers)): ?>
                <?php foreach ($teachers as $teacher): ?>
                  <tr>
                    <td class="text-center">
                    <img src="<?= base_url('uploads/' . (!empty($teacher['photo']) ? $teacher['photo'] : 'default.png')) ?>" width="50" height="50" class="rounded-circle"></td>
                    <td><?= esc($teacher['name']) ?></td>
                    <td><?= esc($teacher['designation']) ?></td>
                    <td><?= esc($teacher['subject']) ?></td>
                    <td><?= esc($teacher['email']) ?></td>
                    <td><?= esc($teacher['phone']) ?></td>
                    <td class="text-center"><?= esc(ucfirst($teacher['gender'])) ?></td>
                    <td class="text-center">
                      <a href="<?= base_url('teacher/edit/' . $teacher['id']) ?>" class="btn btn-sm btn-info">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('teacher/delete/' . $teacher['id']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
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
