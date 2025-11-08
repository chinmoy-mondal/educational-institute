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
                        <a href="<?= base_url('profile_id/' . $user['id']) ?>">
                          <img src="<?= !empty($user['picture'])
                                      ? $user['picture']
                                      : base_url('public/assets/img/default.png') ?>"
                            width="50" height="50" class="rounded-circle">
                        </a>
                      </td>
                      <td><?= esc($user['name']) ?></td>
                      <td><?= esc($user['subject']) ?></td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center">
                          <div style="margin-right:5px;">
                            <a href="#" class="btn btn-sm btn-info edit-btn"
                              data-id="<?= $user['id'] ?>"
                              data-name="<?= esc($user['name']) ?>"
                              data-assign_sub="<?= $user['assagin_sub'] ?>"
                              data-photo="<?= !empty($user['photo'])
                                            ? base_url($user['photo'])
                                            : base_url('public/assets/img/default.png') ?>">
                              <i class="fas fa-edit"></i>
                            </a>
                          </div>
                          <div style="margin-right:5px;">
                            <a href="<?= site_url('profile_id/' . $user['id']) ?>"
                              class="btn btn-sm btn-primary"
                              title="View Profile">
                              <i class="fas fa-user"></i>
                            </a>
                          </div>
                          <div>
                            <a href="<?= site_url('assignSubject/' . $user['id']) ?>"
                              class="btn btn-sm btn-success"
                              title="Exam">
                              <i class="fas fa-file-alt"></i>
                            </a>
                          </div>
                        </div>
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

<!-- CSS for aligned delete button -->
<style>
  #selectedSubjectsList li {
    display: flex;
    justify-content: space-between;
    /* subject left, delete right */
    align-items: center;
    padding: 5px 10px;
    border-bottom: 1px solid #ddd;
    margin-bottom: 2px;
    list-style: decimal;
    /* keeps numbering */
  }

  #selectedSubjectsList li button {
    flex: 0 0 auto;
    /* fixed width */
    width: 25px;
    height: 25px;
    line-height: 20px;
    text-align: center;
    padding: 0;
    font-size: 16px;
    border-radius: 50%;
  }
</style>

<!-- JavaScript for dynamic behavior -->
<script>
  const subjectsLookup = {};
  <?php foreach ($subjects as $sub): ?>
    subjectsLookup['<?= $sub['id'] ?>'] = '<?= esc($sub['subject']) ?> (<?= esc($sub['class']) ?> - <?= esc($sub['section']) ?>)';
  <?php endforeach; ?>

  document.addEventListener('DOMContentLoaded', () => {
    const hidden = document.getElementById('subjectIds');
    const list = document.getElementById('selectedSubjectsList');

    function updateHidden() {
      const ids = Array.from(list.querySelectorAll('li')).map(li => li.dataset.sid);
      hidden.value = ids.join(',');
    }

    // Edit teacher button
    document.querySelector('#teacherTable').addEventListener('click', e => {
      const btn = e.target.closest('.edit-btn');
      if (!btn) return;

      const teacherId = btn.dataset.id;
      const teacherName = btn.dataset.name;
      const assignSub = btn.dataset.assign_sub; // e.g., "2,4,3"

      document.getElementById('teacherId').value = teacherId;
      document.getElementById('teacherName').value = teacherName;

      list.innerHTML = '';

      if (assignSub) {
        assignSub.split(',').forEach(id => {
          if (subjectsLookup[id]) {
            const li = document.createElement('li');
            li.dataset.sid = id;

            const span = document.createElement('span');
            span.textContent = subjectsLookup[id];

            const delBtn = document.createElement('button');
            delBtn.type = 'button';
            delBtn.textContent = '×';
            delBtn.className = 'btn btn-sm btn-danger';
            delBtn.onclick = () => {
              li.remove();
              updateHidden();
            };

            li.appendChild(span);
            li.appendChild(delBtn);
            list.appendChild(li);
          }
        });
      }

      updateHidden();
      document.getElementById('editForm').style.display = 'block';
      document.getElementById('placeholderMsg').style.display = 'none';
    });

    // Add subject from subject list
    document.querySelector('.card-info').addEventListener('click', e => {
      const addBtn = e.target.closest('.add-subject');
      if (!addBtn) return;

      e.preventDefault();
      const sid = addBtn.dataset.sid;
      const sname = addBtn.dataset.sname;

      if (!Array.from(list.querySelectorAll('li')).some(li => li.dataset.sid === sid)) {
        const li = document.createElement('li');
        li.dataset.sid = sid;

        const span = document.createElement('span');
        span.textContent = sname;

        const delBtn = document.createElement('button');
        delBtn.type = 'button';
        delBtn.textContent = '×';
        delBtn.className = 'btn btn-sm btn-danger';
        delBtn.onclick = () => {
          li.remove();
          updateHidden();
        };

        li.appendChild(span);
        li.appendChild(delBtn);
        list.appendChild(li);

        updateHidden();
      }
    });

    document.getElementById('editForm').style.display = 'none';
  });
</script>

<?= $this->endSection() ?>