<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">







    <!-- Summary Cards -->
    <div class="row">
      <!-- Total Students -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= //esc($total_students) ?></h3>
            <p>Current User</p>
          </div>
          <div class="icon"><i class="fas fa-user-graduate"></i></div>
          <a href="<?=// base_url('admin/students') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Total Teachers -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?=// esc($total_teachers) ?></h3>
            <p>New Applied</p>
          </div>
          <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <a href="<?=// base_url('ad_teacher_list') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>









    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i> Teacher List</h3>
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
