<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="card card-primary">
	<div class="card-header">
		<h3 class="card-title">Search Marksheet</h3>
	</div>

	<form action="<?= base_url('admin/show-marksheet') ?>" method="get">
		<div class="card-body row">
			<div class="form-group col-md-3">
				<label>Search By</label>
				<select id="searchType" name="search_type" class="form-control" required>
					<option value="details">Search by Class/Section</option>
					<option value="id">Search by Student ID Only</option>
				</select>
			</div>

			<!-- ID-only field -->
			<div class="form-group col-md-3 search-by-id" style="display: none;">
				<label>Student ID</label>
				<input type="text" name="id" class="form-control" placeholder="Enter Student ID">
			</div>

			<!-- All other fields -->
			<div class="search-by-details row w-100">
				<div class="form-group col-md-3">
					<label>Class</label>
					<select name="class" class="form-control">
						<option value="">Select Class</option>
						<?php foreach ($classes as $class): ?>
							<option value="<?= esc($class['class']) ?>"><?= esc($class['class']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Section</label>
					<select name="section" class="form-control">
						<option value="">Select Section</option>
						<?php foreach ($sections as $sec): ?>
							<option value="<?= esc($sec['section']) ?>"><?= ucfirst(esc($sec['section'])) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Roll No</label>
					<input type="text" name="roll" class="form-control" placeholder="Enter Roll">
				</div>

				<div class="form-group col-md-3">
					<label>Exam</label>
					<select name="exam" class="form-control">
						<option value="">Select Exam</option>
						<?php foreach ($exams as $exam): ?>
							<option value="<?= esc($exam['exam']) ?>"><?= esc($exam['exam']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group col-md-3">
					<label>Year</label>
					<select name="year" class="form-control">
						<option value="">Select Year</option>
						<?php foreach ($years as $year): ?>
							<option value="<?= esc($year['year']) ?>"><?= esc($year['year']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>

		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Show Marksheet</button>
		</div>
	</form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
	const searchType = document.getElementById("searchType");
	const byId = document.querySelector(".search-by-id");
	const byDetails = document.querySelector(".search-by-details");

	function toggleFields() {
		if (searchType.value === "id") {
			byId.style.display = "block";
			byDetails.style.display = "none";
		} else {
			byId.style.display = "none";
			byDetails.style.display = "flex";
		}
	}

	searchType.addEventListener("change", toggleFields);
	toggleFields(); // initialize
});
</script>

<?= $this->endSection() ?>
