<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<section class="content">
  <div class="container-fluid">

    <!-- ROW 1 : teacher table (left) + edit form (right) -->
    <div class="row">

      <!-- LEFT COLUMN : teacher list -->
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
                        <img src="<?= !empty($user['photo'])
                                     ? base_url('uploads/' . $user['photo'])
                                     : base_url('public/assets/img/default.png') ?>"
                             width="50" height="50" class="rounded-circle">
                      </td>
                      <td><?= esc($user['name']) ?></td>
                      <td><?= esc($user['subject']) ?></td>
                      <td class="text-center">
                        <a  href="#"
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

                  <?php if (empty($users)): ?>
                    <tr><td colspan="4" class="text-center text-muted">No teachers found.</td></tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div><!-- /col-md-6 -->

      <!-- RIGHT COLUMN : edit form -->
      <div class="col-md-6">
        <div class="card card-success card-outline shadow">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit"></i> Edit Teacher</h3>
          </div>

          <div class="card-body">
            <form id="editForm" action="<?= base_url('teacher/update') ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="id"           id="teacherId">
              <input type="hidden" name="subject_ids" id="subjectIds">

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
      </div><!-- /col-md-6 -->
    </div><!-- /row 1 -->

    <!-- ROW 2 : subject list with “add” icons -->
    <div class="row mt-4">
      <div class="col-12">
        <div class="card card-info card-outline shadow">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-book"></i> Subject List</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-hover">
              <thead class="bg-info text-white">
                <tr>
                  <th>#</th>
                  <th>Subject</th>
                  <th>Add</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($subjects as $sub): ?>
                  <tr>
                    <td><?= $sub['id'] ?></td>
                    <td><?= esc($sub['subject']) ?></td>
                    <td class="text-center">
                      <a  href="#"
                          class="btn btn-sm btn-primary add-subject"
                          data-sid="<?= $sub['id'] ?>"
                          data-sname="<?= esc($sub['subject']) ?>">
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
    </div><!-- /row 2 -->

  </div><!-- /container-fluid -->
</section>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {

  /* Fill form when edit clicked */
  document.querySelector('#teacherTable').addEventListener('click', e => {
    const btn = e.target.closest('.edit-btn');
    if (!btn) return;

    document.getElementById('teacherId').value   = btn.dataset.id;
    document.getElementById('teacherName').value = btn.dataset.name;

    //  reset subject fields
    document.getElementById('subjectIds').value              = '';
    document.getElementById('selectedSubjectsList').innerHTML = '';

    document.getElementById('editForm').style.display   = 'block';
    document.getElementById('placeholderMsg').style.display = 'none';
  });

  /* Add subject to hidden input & list */
  document.querySelector('.card-info').addEventListener('click', e => {
    const addBtn = e.target.closest('.add-subject');
    if (!addBtn) return;

    const sid   = addBtn.dataset.sid;
    const sname = addBtn.dataset.sname;

    const hidden = document.getElementById('subjectIds');
    let ids      = hidden.value ? hidden.value.split(',') : [];

    if (!ids.includes(sid)) {
      ids.push(sid);
      hidden.value = ids.join(',');

      const li = document.createElement('li');
      li.textContent = sname;
      document.getElementById('selectedSubjectsList').appendChild(li);
    }
  });

  // hide form until a teacher is selected
  document.getElementById('editForm').style.display = 'none';
});
</script>

<?= $this->endSection() ?>
