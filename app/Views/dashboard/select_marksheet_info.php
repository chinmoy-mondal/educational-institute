<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Search Marksheet</h3>
	</div>

	<form action="<?= base_url('show-marksheet') ?>" method="get">
		<div class="card-body row">
			<div class="form-group col-md-3">
				<label>Class</label>
				<select name="class" class="form-control" required>
					<option value="">Select Class</option>
					<?php foreach ($classes as $class): ?>
						<option value="<?= esc($class['class']) ?>"><?= esc($class['class']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group col-md-3">
				<label>Section</label>
				<select name="section" class="form-control" required>
					<option value="">Select Section</option>
					<?php foreach ($sections as $sec): ?>
						<option value="<?= esc($sec['section']) ?>"><?= ucfirst(esc($sec['section'])) ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group col-md-3">
				<label>Roll No / Student ID</label>
				<input type="text" name="roll" class="form-control" placeholder="Enter Roll or ID" required>
			</div>

			<div class="form-group col-md-3">
				<label>Exam</label>
				<select name="exam" class="form-control" required>
					<option value="">Select Exam</option>
					<?php foreach ($exams as $exam): ?>
						<option value="<?= esc($exam['exam']) ?>"><?= esc($exam['exam']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group col-md-3">
				<label>Year</label>
				<select name="year" class="form-control" required>
					<option value="">Select Year</option>
					<?php foreach ($years as $year): ?>
						<option value="<?= esc($year['year']) ?>"><?= esc($year['year']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Show Marksheet</button>
		</div>
	</form>
</div>

<?= $this->endSection() ?>
