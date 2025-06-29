<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="row">

      <!-- Left: Teacher List Table -->
      <div class="col-md-6">
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
                    <th>Subject</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                      <tr>
                        <td class="text-center">
                          <img src="<?= !empty($user['photo']) 
                            ? base_url('uploads/' . $user['photo']) 
                            : base_url('public/assets/img/default.png') ?>" 
                            width="50" height="50" class="rounded-circle">
                        </td>
                        <td><?= esc($user['name']) ?></td>
                        <td><?= esc($user['subject']) ?></td>
                        <td class="text-center">
                          <a href="#"
                             class="btn btn-sm btn-info edit-btn"
                             data-id="<?= $user['id'] ?>"
                             data-name="<?= esc($user['name']) ?>"
                             data-subject="<?= esc($user['subject']) ?>"
                             data-photo="<?= !empty($user['photo']) 
                                ? base_url('uploads/' . $user['photo']) 
                                : base_url('public/assets/img/default.png') ?>">
                            <i class="fas fa-edit"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr><td colspan="4" class="text-center text-muted">No teachers found.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Right: Edit Form -->
      <div class="col-md-6">
        <div class="card card-success card-outline shadow">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit"></i> Edit Teacher</h3>
          </div>

          <div class="card-body">
            <form id="editForm" action="<?= base_url('teacher/update') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>
              <input type="hidden" name="id" id="teacherId">

              <div class="text-center mb-3">
                <img id="previewImg" src="<?= base_url('public/assets/img/default.png') ?>" 
                     class="rounded-circle" width="80" height="80">
              </div>

              <div class="form-group mb-3">
                <label for="teacherName">Name</label>
                <input type="text" name="name" id="teacherName" class="form-control" placeholder="Enter name">
              </div>

              <div class="form-group mb-3">
                <label for="teacherSubject">Subject</label>
                <input type="text" name="subject" id="teacherSubject" class="form-control" placeholder="Enter subject">
              </div>

              <div class="form-group mb-3">
                <label for="teacherPhoto">Upload New Photo</label>
                <input type="file" name="photo" id="teacherPhoto" class="form-control">
              </div>

              <button type="submit" class="btn btn-success w-100">Update</button>
            </form>

            <p id="placeholderMsg" class="text-muted text-center mt-3">
              Click the <i class="fas fa-edit"></i> button to load a teacher’s data.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- JavaScript to fill the form -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelector('#teacherTable').addEventListener('click', function (e) {
    const btn = e.target.closest('.edit-btn');
    if (!btn) return;

    // Read data from clicked button
    const id = btn.dataset.id;
    const name = btn.dataset.name;
    const subject = btn.dataset.subject;
    const photo = btn.dataset.photo;

    // Fill the form
    document.getElementById('teacherId').value = id;
    document.getElementById('teacherName').value = name;
    document.getElementById('teacherSubject').value = subject;
    document.getElementById('previewImg').src = photo;

    // Show form, hide placeholder
    document.getElementById('editForm').style.display = 'block';
    document.getElementById('placeholderMsg').style.display = 'none';
  });

  // Hide form at first
  document.getElementById('editForm').style.display = 'none';
});
</script>

<?= $this->endSection() ?>
