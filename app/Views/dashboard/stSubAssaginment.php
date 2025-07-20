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

    <!-- Search & Filter Form -->
    <div class="card">
      <div class="card-body">
      <form method="get" action="<?= site_url('admin/stAssaginSubView') ?>" >
          <div class="row align-items-end">
            <div class="col-md-4">
              <div class="form-group">
                <label for="search">Search</label>
                <input type="text" name="q" id="search" class="form-control" placeholder="Name, Roll, or ID" value="<?= esc($q ?? '') ?>">
              </div>
            </div>
            <div class="col-md-3">
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
            <div class="col-md-3">
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
                <label class="invisible d-block">Search</label>
                <button type="submit" class="btn btn-primary w-100">Search</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
	<div class="row">
	  <!-- Left Select -->
	  <div class="col-md-6">
	    <div class="form-group">
	      <label for="leftSelect">Select Students (Left)</label>
	      <select multiple class="form-control select2" id="leftSelect" name="left_select[]" style="height: 400px; width: 100%;">
		<?php foreach ($students as $s): ?>
		  <option value="<?= esc($s['id']) ?>">
		    <pre><?= esc($s['class']) . "\t" . esc($s['roll']) . "\t" . esc($s['student_name']) . "\t" . esc($s['section']) ?></pre>
		  </option>
		<?php endforeach ?>
	      </select>
	    </div>
	  </div>

	  <!-- Right Select -->
	  <div class="col-md-6">
	    <div class="form-group">
	      <label for="rightSelect">Select Students (Right)</label>
	      <select multiple  class="form-control select2" id="rightSelect" name="right_select[]" style="height:400px; width: 100%;">
		<?php foreach ($students as $s): ?>
		  <option value="<?= esc($s['id']) ?>">
		    <?= esc($s['student_name']) ?> (<?= esc($s['roll']) ?>)
		  </option>
		<?php endforeach ?>
	      </select>
	    </div>
	  </div>
	</div>
    <!-- Student Table -->
    <?php if (!empty($students)): ?>
      <div class="card">
        <div class="card-body table-responsive p-0">
	  <table class="table table-bordered table-hover">

		<!-- Table Header -->
		<thead class="table-light">
		  <tr>
		    <th>ID</th>
		    <th>Name</th>
		    <th>Roll</th>
		    <th>Class</th>
		    <th>Section</th>
		    <th>Action</th> <!-- New column -->
		  </tr>
		</thead>

		<!-- Table Rows -->
		<tbody>
		  <?php foreach ($students as $s): ?>
		    <tr>
		      <td><?= esc($s['id']) ?></td>
		      <td><?= esc($s['student_name']) ?></td>
		      <td><?= esc($s['roll']) ?></td>
		      <td><?= esc($s['class']) ?></td>
		      <td><?= esc($s['section']) ?></td>
		      <td>
			<a href="<?= site_url('admin/students/view/' . $s['id']) ?>" class="btn btn-info btn-sm" target="_blank" >
			  <i class="fas fa-eye"></i> View
			</a>
		      </td>
		    </tr>
		  <?php endforeach ?>
		</tbody>



          </table>
        </div>
      </div>
    <?php else: ?>
      <div class="alert alert-info">No students found.</div>
    <?php endif ?>


   </div>
</div>

<?= $this->endSection() ?>

