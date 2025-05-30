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
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>10</h3>
            <p>Leave Applications</p>
          </div>
          <div class="icon"><i class="fas fa-calendar-alt"></i></div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>$1200</h3>
            <p>Payments Collected</p>
          </div>
          <div class="icon"><i class="fas fa-dollar-sign"></i></div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>3</h3>
            <p>Results Pending</p>
          </div>
          <div class="icon"><i class="fas fa-chart-bar"></i></div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>$300</h3>
            <p>Monthly Expenses</p>
          </div>
          <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</div>

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
              <th>Email</th>
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
                  <td><?= esc($student['email']) ?></td>
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

<?= $this->endSection() ?>
