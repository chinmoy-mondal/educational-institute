<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!--  PAGE : Teacher Management  -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- ───────────────────────────────────────────────
           LEFT COLUMN – Teacher List
      ─────────────────────────────────────────────── -->
      <div class="col-md-6">
        <div class="card card-primary card-outline shadow">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
              <i class="fas fa-chalkboard-teacher"></i> Teacher List
            </h3>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="teacherTable" class="table table-bordered table-hover table-striped">
                <thead class="bg-navy text-center">
                  <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th style="width:120px" class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($users as $user): ?>
                    <tr>
                      <td class="text-center">
                        <img src="<?= !empty($user['photo'])
                          ? base_url('uploads/' . $user['photo'])
                          : base_url('public/assets/img/default.png') ?>"
                          class="rounded-circle" width="50" height="50" alt="photo">
                      </td>
                      <td><?= esc($user['name']) ?></td>
                      <td><?= esc($user['subject']) ?></td>
                      <td class="text-center">
                        <!-- View button -->
                        <a href="#" class="btn btn-sm btn-secondary view-btn me-1"
                           data-id="<?= $user['id'] ?>"
                           data-name="<?= esc($user['name']) ?>"
                           data-subject="<?= esc($user['subject']) ?>"
                           data-designation="<?= esc($user['designation'] ?? 'N/A') ?>"
                           data-photo="<?= !empty($user['photo'])
                             ? base_url('uploads/' . $user['photo'])
                             : base_url('public/assets/img/default.png') ?>">
                          <i class="fas fa-eye"></i>
                        </a>

                        <!-- Edit button -->
                        <a href="#" class="btn btn-sm btn-info edit-btn"
                           data-id="<?= $user['id'] ?>"
                           data-name="<?= esc($user['name']) ?>">
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
      </div><!-- /LEFT -->

      <!-- ───────────────────────────────────────────────
           RIGHT COLUMN – Edit Form + Subject List
      ─────────────────────────────────────────────── -->
      <div class="col-md-6">
        <!-- ↓ Edit Form -->
        <div class="card card-success card-outline shadow">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-user-edit"></i> Edit Teacher</h3>
          </div>
          <div class="card-body">
            <form id="editForm" action="<?= base_url('sub-update') ?>" method="post">
              <?= csrf_field() ?>
              <input type="hidden" name="id"         id="teacherId">
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
              Click <i class="fas fa-edit"></i> to load a teacher, then add subjects.
            </p>
          </div>
        </div>

        <!-- ↓ Subject List -->
        <div class="card card-info card-outline shadow mt-3">
          <div class="card-header">
            <h3 class="card-title mb-0"><i class="fas fa-book"></i> Subject List</h3>
          </div>
          <div class="card-body p-0">
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
      </div><!-- /RIGHT -->
    </div><!-- /row -->
  </div><!-- /container-fluid -->
</section>

<!-- ───────── Bootstrap-4 Modal (View Info) ───────── -->
<div class="modal fade" id="teacherModal" tabindex="-1" role="dialog" aria-labelledby="teacherModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="teacherModalLabel">Teacher Info</h5>
        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalPhoto" class="rounded-circle mb-3" width="80" height="80" alt="photo">
        <h5 id="modalName" class="mb-1"></h5>
        <p class="mb-0"><strong>Designation:</strong> <span id="modalDesignation"></span></p>
        <p class="mb-0"><strong>Subject:</strong> <span id="modalSubject"></span></p>
      </div>
    </div>
  </div>
</div>

<!-- ───────── Page-specific JS ───────── -->
<script>
$(function () {

  /* --- VIEW MODAL --- */
  $('#teacherTable').on('click', '.view-btn', function () {
    $('#modalName').text($(this).data('name'));
    $('#modalSubject').text($(this).data('subject'));
    $('#modalDesignation').text($(this).data('designation'));
    $('#modalPhoto').attr('src', $(this).data('photo'));
    $('#teacherModal').modal('show');
  });

  /* --- EDIT FORM --- */
  $('#teacherTable').on('click', '.edit-btn', function () {
    $('#teacherId').val($(this).data('id'));
    $('#teacherName').val($(this).data('name'));
    $('#subjectIds').val('');
    $('#selectedSubjectsList').empty();
    $('#editForm').show();
    $('#placeholderMsg').hide();
  });

  /* --- ADD SUBJECT --- */
  $('.card-info').on('click', '.add-subject', function () {
    const sid   = $(this).data('sid');
    const sname = $(this).data('sname');
    const hidden = $('#subjectIds');
    let ids = hidden.val() ? hidden.val().split(',') : [];

    if (!ids.includes(String(sid))) {
      ids.push(sid);
      hidden.val(ids.join(','));
      $('#selectedSubjectsList').append('<li>' + sname + '</li>');
    }
  });

  $('#editForm').hide(); // form hidden until edit action
});
</script>

<?= $this->endSection() ?>
