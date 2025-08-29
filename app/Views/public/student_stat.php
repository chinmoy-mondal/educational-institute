<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row">
    <!-- Total Students -->
    <div class="col-md-4">
      <div class="card text-white bg-primary mb-3 shadow">
        <div class="card-body text-center">
          <h4>Total Students</h4>
          <h2><?= $total ?></h2>
        </div>
      </div>
    </div>

    <!-- Students by Class -->
    <div class="col-md-4">
      <div class="card mb-3 shadow">
        <div class="card-header bg-success text-white">By Class</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($byClass as $row): ?>
            <li class="list-group-item">Class <?= $row['class'] ?>: <b><?= $row['total'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Students by Section -->
    <div class="col-md-4">
      <div class="card mb-3 shadow">
        <div class="card-header bg-info text-white">By Section</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($bySection as $row): ?>
            <li class="list-group-item">Section <?= $row['section'] ?>: <b><?= $row['total'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Gender -->
    <div class="col-md-4">
      <div class="card mb-3 shadow">
        <div class="card-header bg-warning text-white">By Gender</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($byGender as $row): ?>
            <li class="list-group-item"><?= ucfirst($row['gender']) ?>: <b><?= $row['total'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Religion -->
    <div class="col-md-4">
      <div class="card mb-3 shadow">
        <div class="card-header bg-secondary text-white">By Religion</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($byReligion as $row): ?>
            <li class="list-group-item"><?= ucfirst($row['religion']) ?>: <b><?= $row['total'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

    <!-- Blood Group -->
    <div class="col-md-4">
      <div class="card mb-3 shadow">
        <div class="card-header bg-danger text-white">By Blood Group</div>
        <ul class="list-group list-group-flush">
          <?php foreach ($byBloodGroup as $row): ?>
            <li class="list-group-item"><?= strtoupper($row['blood_group']) ?>: <b><?= $row['total'] ?></b></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>