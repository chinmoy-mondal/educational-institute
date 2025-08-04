<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container d-flex justify-content-center mt-5">
	<div class="card card-primary w-100" style="max-width: 600px;">
		<div class="card-header">
			<h3 class="card-title">Search Marksheet</h3>

		</div>

		<form action="<?= base_url('admin/show-marksheet') ?>" method="get"><br>
			<?php if (session()->getFlashdata('success')): ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<?= session()->getFlashdata('success') ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>

			<?php if (session()->getFlashdata('error')): ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
					<?= session()->getFlashdata('error') ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			<?php endif; ?>
			<div class="card-body">

				<!-- 🔘 Radio buttons -->
				<div class="form-group">
					<label>Search Method</label><br>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="search_type" id="searchById" value="id" checked>
						<label class="form-check-label" for="searchById">By Student ID</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="search_type" id="searchByRoll" value="roll">
						<label class="form-check-label" for="searchByRoll">By Class/Roll</label>
					</div>
				</div>

				<!-- 👤 Student ID -->
				<div class="form-group search-id">
					<label>Student ID</label>
					<input type="text" name="id" class="form-control" placeholder="Enter Student ID">
				</div>

				<div class="form-group search-id">
					<label>Exam</label>
					<select name="exam" class="form-control">
						<option value="">Select Exam</option>
						<?php foreach ($exams as $exam): ?>
							<option value="<?= esc($exam['exam']) ?>"><?= esc($exam['exam']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="form-group search-id">
					<label>Year</label>
					<select name="year" class="form-control">
						<option value="">Select Year</option>
						<?php foreach ($years as $year): ?>
							<option value="<?= esc($year['year']) ?>"><?= esc($year['year']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>

				<!-- 📋 Class/Roll-based fields -->
				<div class="search-roll" style="display: none;">
					<div class="form-group">
						<label>Class</label>
						<select name="class" class="form-control">
							<option value="">Select Class</option>
							<?php foreach ($classes as $class): ?>
								<option value="<?= esc($class['class']) ?>"><?= esc($class['class']) ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label>Section</label>
						<select name="section" class="form-control">
							<option value="">Select Section</option>
							<?php foreach ($sections as $sec): ?>
								<option value="<?= esc($sec['section']) ?>"><?= ucfirst(esc($sec['section'])) ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label>Roll</label>
						<input type="text" name="roll" class="form-control" placeholder="Enter Roll Number">
					</div>

					<div class="form-group">
						<label>Exam</label>
						<select name="exam" class="form-control">
							<option value="">Select Exam</option>
							<?php foreach ($exams as $exam): ?>
								<option value="<?= esc($exam['exam']) ?>"><?= esc($exam['exam']) ?></option>
							<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
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

			<div class="card-footer text-center">
				<button type="submit" class="btn btn-primary">Show Marksheet</button>
			</div>
		</form>
	</div>
</div>

<!-- ✅ JavaScript: Toggle fields -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		const searchById = document.getElementById("searchById");
		const searchByRoll = document.getElementById("searchByRoll");

		const idFields = document.querySelector(".search-id");
		const rollFields = document.querySelector(".search-roll");

		function toggleSearch() {
			if (searchById.checked) {
				idFields.style.display = "block";
				rollFields.style.display = "none";
			} else {
				idFields.style.display = "none";
				rollFields.style.display = "block";
			}
		}

		searchById.addEventListener("change", toggleSearch);
		searchByRoll.addEventListener("change", toggleSearch);
		toggleSearch(); // initial call
	});
</script>

<?= $this->endSection() ?>