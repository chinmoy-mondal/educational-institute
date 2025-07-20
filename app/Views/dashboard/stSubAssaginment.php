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
			<option vaule="<?= esc($s['id']) ?>">
			<pre>
			<?= esc($s['class']) ?>
			<?= (strlen((string)$s['class']) == 1) ? str_repeat('&nbsp;', 10) : str_repeat('&nbsp;', 8) ?>
			<?= esc($s['roll']) ?>
			<?= (strlen((string)$s['roll']) == 1) ? str_repeat('&nbsp;', 10) : str_repeat('&nbsp;', 8) ?>
			<?= esc($s['student_name'])  ?>
			</pre>
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
		<?php foreach ($subjects as $s): ?>
		  <option value="<?= esc($s['id']) ?>">
		    <?= esc($s['class']) ?>
		    <?= (strlen((string)$s['class']) == 1) ? str_repeat('&nbsp;', 10) : str_repeat('&nbsp;', 8) ?>
		    <?= esc($s['subject']) ?>
		  </option>
		<?php endforeach ?>
	      </select>
	    </div>
	  </div>
	</div>
   </div>
</div>

<?= $this->endSection() ?>

