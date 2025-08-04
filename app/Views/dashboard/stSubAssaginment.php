<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Student List</h1>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">

    <!-- Flash Messages -->
    <?php if (session()->has('success')): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php elseif (session()->has('error')): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- Search & Filter Form -->
    <div class="card">
	    <div class="card-body">
		    <form method="get" action="<?= site_url('admin/stAssaginSubView') ?>">
			    <div class="row align-items-end">
				    <div class="col-md-4">
					    <div class="form-group">
						    <label for="search">Search</label>
						    <input type="text" name="q" id="search" class="form-control" placeholder="Name, Roll, or ID" value="<?= esc($q ?? '') ?>">
					    </div>
				    </div>
				    <div class="col-md-2">
					    <div class="form-group">
						    <label for="class">Class</label>
						    <select name="class" id="class" class="form-control">
							    <option value="" <?= ($class ?? '') === '' ? 'selected' : '' ?>>All Classes</option>
							    <?php for ($i = 6; $i <= 10; $i++): ?>
							    <option value="<?= $i ?>" <?= ($class ?? '') == $i ? 'selected' : '' ?>>Class <?= $i ?></option>
							    <?php endfor; ?>
						    </select>
					    </div>
				    </div>
				    <div class="col-md-2">
					    <div class="form-group">
						    <label for="section">Section</label>
						    <select name="section" id="section" class="form-control">
							    <option value="" <?= ($section ?? '') === '' ? 'selected' : '' ?>>All Sections</option>
							    <?php foreach ($sections as $sec): ?>
							    <option value="<?= esc($sec['section']) ?>" <?= ($section ?? '') === $sec['section'] ? 'selected' : '' ?>>
							    <?= esc($sec['section']) ?>
							    </option>
						    <?php endforeach; ?>
						    </select>
					    </div>
				    </div>
				    <div class="col-md-2">
					    <div class="form-group">
						    <label for="religion">Religion</label>
						    <select name="religion" id="religion" class="form-control">
							    <option value="" <?= ($religion ?? '') === '' ? 'selected' : '' ?>>All Religions</option>
							    <?php foreach ($religions as $r): ?>
								    <option value="<?= esc($r['religion']) ?>" <?= ($religion ?? '') === $r['religion'] ? 'selected' : '' ?>>
									    <?= esc(ucfirst($r['religion'])) ?>
								    </option>
							    <?php endforeach; ?>
						    </select>
					    </div>
				    </div>
				    <div class="col-md-2">
					    <div class="form-group">
						    <label class="invisible d-block">Search</label>
						    <button type="submit" class="btn btn-primary w-100">Search</button>
					    </div>
				    </div>
			    </div>
		    </form>
	    </div>
    </div>

    <!-- Assignment Form -->
    <form method="post" action="<?= site_url('admin/assignStudentsSubjects') ?>">
      <?= csrf_field() ?>
      <div class="row">
        <!-- Left Select -->
        <div class="col-md-6">
          <div class="form-group">
            <label for="leftSelect">Select Students (Left)</label>
            <select multiple class="form-control select2" id="leftSelect" name="left_select[]" style="height: 400px; width: 100%;">
              <?php foreach ($students as $s): ?>
                <option value="<?= esc($s['id']) ?>">
                  <?= esc($s['class']) ?> &nbsp;&nbsp; <?= esc($s['roll']) ?> &nbsp;&nbsp; <?= esc($s['student_name']) ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>

        <!-- Right Select -->
        <div class="col-md-6">
          <div class="form-group">
            <label for="rightSelect">Select Subjects (Right)</label>
            <select multiple class="form-control select2" id="rightSelect" name="right_select[]" style="height:400px; width: 100%;">
              <?php foreach ($subjects as $s): ?>
                <option value="<?= esc($s['id']) ?>">
                  <?= esc($s['class']) ?> &nbsp;&nbsp; <?= esc($s['subject']) ?>
                </option>
              <?php endforeach ?>
            </select>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="row">
        <div class="col-md-12 text-center mt-3">
          <button type="submit" class="btn btn-success">Assign Subjects to Students</button>
        </div>
      </div>
    </form>

  </div>
</div>

<?= $this->endSection() ?>

<!-- Optional: Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- ✅ Init Select2 (optional) -->
<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "Select Subjects",
      closeOnSelect: false
    });
  });
</script>