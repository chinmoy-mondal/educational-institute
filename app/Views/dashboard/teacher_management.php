<?= $this->extend("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- LEFT COLUMN: Teacher Table -->
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
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td class="text-center">
                        <a href="<?= base_url('assignSubject/' . $user['id']) ?>">
                          <img src="<?= !empty($user['photo'])
                                      ? base_url('uploads/' . $user['photo'])
                                      : base_url('public/assets/img/default.png') ?>"
                            width="50" height="50" class="rounded-circle">
                        </a>

                      </td>
                      <td><?= esc($user['name']) ?></td>
                      <td><?= esc($user['subject']) ?></td>
                      <td class="text-center">
                        <a href="#" class="btn btn-sm btn-info edit-btn"
                          data-id="<?= $user['id'] ?>"
                          data-name="<?= esc($user['name']) ?>"
                          data-subject="<?= esc($user['subject']) ?>"
                          data-photo="<?= !empty($user['photo'])
                                        ? base_url('uploads/' . $user['photo'])
                                        : base_url('public/assets/img/default.png') ?>">
                          <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= site_url('profile_id/' . $user['id']) ?>"
                          class="text-primary">
                          <i class="fas fa-user"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- RIGHT COLUMN: Edit + Subject List -->
      <div class="col-md-6">
        <!-- Edit Teacher Card -->
        <div class="card card-success card-outline shadow">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit"></i> Edit Teacher</h3>
          </div>
          <div class="card-body">
            <form id="editForm" action="<?= base_url('sub-update') ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="id" id="teacherId">
              <input type="hidden" name="assign_sub" id="subjectIds">

              <div class="form-group mb-3">
                <label>Name</label>
                <input type="text" name="name" id="teacherName" class="form-control">
              </div>

              <div class="mb-3">
                <label>Subjects Assigned</label>
                <ol id="selectedSubjectsList" class="ps-3"></ol>
              </div>

              <button type="submit" class="btn btn-success w-100">Update</button>
            </form>

            <p id="placeholderMsg" class="text-muted text-center mt-3">
              Click the <i class="fas fa-edit"></i> button to load a teacher and then add subjects below.
            </p>
          </div>
        </div>

        <!-- Subject List Card (below edit form) -->
        <div class="card card-info card-outline shadow mt-3">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-book"></i> Subject List</h3>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover m-0">
                <thead class="bg-info text-white text-center">
                  <tr>
                    <th>#</th>
                    <th>Subject</th>
                    <th>Class</th>
                    <th>Section</th>
                    <th>Add</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($subjects as $sub): ?>
                    <tr>
                      <td><?= $sub['id'] ?></td>
                      <td><?= esc($sub['subject']) ?></td>
                      <td><?= esc($sub['class']) ?></td>
                      <td><?= esc($sub['section']) ?></td>
                      <td class="text-center">
                        <a href="#" class="btn btn-sm btn-primary add-subject"
                          data-sid="<?= $sub['id'] ?>"
                          data-sname="<?= esc($sub['subject']) ?> (<?= esc($sub['class']) ?> - <?= esc($sub['section']) ?>)">
                          <i class="fas fa-plus"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div> <!-- /col-md-6 -->
    </div> <!-- /row -->
  </div>
</section>

<!-- JavaScript for dynamic behavior (unchanged) -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelector('#teacherTable').addEventListener('click', e => {
      const btn = e.target.closest('.edit-btn');
      if (!btn) return;

      document.getElementById('teacherId').value = btn.dataset.id;
      document.getElementById('teacherName').value = btn.dataset.name;
      document.getElementById('subjectIds').value = '';
      document.getElementById('selectedSubjectsList').innerHTML = '';
      document.getElementById('editForm').style.display = 'block';
      document.getElementById('placeholderMsg').style.display = 'none';
    });

    document.querySelector('.card-info').addEventListener('click', e => {
      const addBtn = e.target.closest('.add-subject');
      if (!addBtn) return;

      e.preventDefault();

      const sid = addBtn.dataset.sid;
      const sname = addBtn.dataset.sname;
      const hidden = document.getElementById('subjectIds');
      let ids = hidden.value ? hidden.value.split(',') : [];

      if (!ids.includes(sid)) {
        ids.push(sid);
        hidden.value = ids.join(',');
        const li = document.createElement('li');
        li.textContent = sname;
        document.getElementById('selectedSubjectsList').appendChild(li);
      }
    });

    document.getElementById('editForm').style.display = 'none';
  });
</script>

<?= $this->endSection() ?>