<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
    </div>
  </div>
</div>

<div class="content">
  <div class="container-fluid">

    <!-- Summary Cards -->
    <div class="row">
      <!-- Total Students -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3><?= esc($total_students) ?></h3>
            <p>Total Students</p>
          </div>
          <div class="icon"><i class="fas fa-user-graduate"></i></div>
          <a href="<?= base_url('admin/students') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Total Teachers -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?= esc($total_teachers) ?></h3>
            <p>Total Teachers</p>
          </div>
          <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
          <a href="<?= base_url('ad_teacher_list') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Leave Applications -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?= esc($total_applications) ?></h3>
            <p>Leave Applications</p>
          </div>
          <div class="icon"><i class="fas fa-calendar-alt"></i></div>
          <a href="<?= base_url('admin/applications') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Exams -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?= esc($total_exams) ?></h3>
            <p>Exams</p>
          </div>
          <div class="icon"><i class="fas fa-pencil-ruler"></i></div>
          <a href="<?= base_url('admin/exams') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Total Income -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>৳<?= esc(number_format($total_income, 2)) ?></h3>
            <p>Total Income test chinmoy</p>
          </div>
          <div class="icon"><i class="fas fa-coins"></i></div>
          <a href="<?= base_url('admin/income') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <!-- Total Cost -->
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>৳<?= esc(number_format($total_cost, 2)) ?></h3>
            <p>Total Cost</p>
          </div>
          <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
          <a href="<?= base_url('admin/cost') ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>

    <!-- Students Table -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All Students</h3>
          </div>
          <div class="card-body table-responsive p-0" style="max-height: 400px;">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Roll</th>
                  <th>Class</th>
                  <th>Phone</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!empty($students)): ?>
                  <?php foreach ($students as $student): ?>
                    <tr>
                      <td><?= esc($student['id']) ?></td>
                      <td><?= esc($student['student_name']) ?></td>
                      <td><?= esc($student['roll']) ?></td>
                      <td><?= esc($student['class']) ?></td>
                      <td><?= esc($student['phone']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                <?php else: ?>
                  <tr>
                    <td colspan="5">No students found.</td>
                  </tr>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>
