<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Teacher Attendance Report</h1>
			</div>
		</div>
	</div>
</div>

<div class="content">
	<div class="container-fluid">

		<!-- Filter Form -->
		<div class="card mb-3">
			<div class="card-body">
				<form method="get" class="row g-3">
					<div class="col-md-4">
						<div class="form-group">
							<label for="teacher">Select Teacher</label>
							<select name="teacher" id="teacher" class="form-control">
								<option value="">All Teachers</option>
								<?php foreach ($allTeachers as $t): ?>
									<option value="<?= esc($t['id']) ?>" <?= ($selectedTeacher == $t['id']) ? 'selected' : '' ?>>
										<?= esc($t['name']) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<div class="form-group">
							<label for="month">Month</label>
							<input type="month" name="month" id="month" class="form-control" value="<?= esc($selectedMonth) ?>">
						</div>
					</div>

					<div class="col-md-2 d-grid">
						<button type="submit" class="btn btn-primary mt-4">Filter</button>
					</div>
				</form>
			</div>
		</div>

		<!-- Attendance Table -->
		<?php if (!empty($teachers)): ?>
			<div class="card">
				<div class="card-body table-responsive p-0" style="max-height:600px; overflow-y:auto;">
					<table class="table table-bordered table-hover table-sm text-center">
						<thead class="table-light sticky-top">
							<tr>
								<th style="min-width:150px;">Teacher</th>
								<?php foreach ($daysInMonth as $day): ?>
									<th style="min-width:40px;" title="<?= esc($day['date']) ?>">
										<?= esc($day['day']) ?><br><?= date('d', strtotime($day['date'])) ?>
									</th>
								<?php endforeach; ?>
								<th style="min-width:70px;">Total</th>
								<th style="min-width:70px;">Present</th>
								<th style="min-width:80px;">% Present</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($teachers as $t): ?>
								<tr>
									<td class="text-start"><?= esc($t['name']) ?></td>
									<?php
									$totalDays = 0;
									$presentCount = 0;
									?>
									<?php foreach ($daysInMonth as $day): ?>
										<?php
										$date = $day['date'];
										$dayName = $day['day'];
										$att = $attendanceMap[$t['id']][$date] ?? null;

										// Count weekdays only
										if (!in_array($dayName, ['Fri', 'Sat'])) {
											$totalDays++;
										}

										$status = 'A'; // default Absent
										$tooltip = 'Absent';

										if ($att) {
											$inSec = $att['arrival'] ? strtotime($att['arrival']) : null;
											$outSec = $att['leave'] ? strtotime($att['leave']) : null;

											$tenAM = strtotime($date . ' 10:00:00');
											$fourPM = strtotime($date . ' 16:00:00');

											if ($inSec && $outSec) {
												if ($inSec <= $tenAM && $outSec >= $fourPM) {
													$status = 'P';
													$presentCount++;
												} elseif ($inSec > $tenAM && $outSec < $fourPM) {
													$status = 'L/E';
												} elseif ($inSec > $tenAM) {
													$status = 'L';
												} elseif ($outSec < $fourPM) {
													$status = 'E';
												}
											} elseif ($inSec && !$outSec) {
												$status = ($inSec > $tenAM) ? 'L' : 'P';
												$presentCount += ($status === 'P') ? 1 : 0;
											} elseif (!$inSec && $outSec) {
												$status = ($outSec < $fourPM) ? 'E' : 'P';
												$presentCount += ($status === 'P') ? 1 : 0;
											}
											$tooltip = "In: " . ($att['arrival'] ? date('H:i', strtotime($att['arrival'])) : '--') .
												", Out: " . ($att['leave'] ? date('H:i', strtotime($att['leave'])) : '--');
										} else {
											// Holiday on Fri/Sat
											if (in_array($dayName, ['Fri', 'Sat'])) {
												$status = 'H';
												$tooltip = 'Holiday';
											}
										}

										$badgeClass = match ($status) {
											'P' => 'bg-success',
											'A' => 'bg-white text-dark',
											'L' => 'bg-warning text-dark',
											'E' => 'bg-info text-dark',
											'L/E' => 'bg-primary',
											'H' => 'bg-secondary text-white',
											default => 'bg-secondary'
										};
										?>
										<td><span class="badge <?= $badgeClass ?>" title="<?= esc($tooltip) ?>"><?= esc($status) ?></span></td>
									<?php endforeach; ?>
									<td><strong><?= $totalDays ?></strong></td>
									<td><strong><?= $presentCount ?></strong></td>
									<td><strong><?= $totalDays > 0 ? round(($presentCount / $totalDays) * 100) : 0 ?>%</strong></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		<?php else: ?>
			<div class="alert alert-info">No teachers found.</div>
		<?php endif; ?>

	</div>
</div>

<?= $this->endSection() ?>