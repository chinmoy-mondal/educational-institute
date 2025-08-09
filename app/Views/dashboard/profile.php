<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

  <!-- Profile Card with Ribbon -->
  <div class="card position-relative mb-4" style="padding: 20px;">

    <!-- Ribbon -->
    <div class="ribbon-wrapper ribbon-lg">
      <div class="ribbon bg-success text-lg">
        Active
      </div>
    </div>

    <div class="row align-items-center">
      <!-- Left: Photo -->
      <div class="col-md-3 text-center">
        <img src="https://via.placeholder.com/150" alt="Teacher Photo" class="img-fluid img-circle" style="max-width:150px;">
      </div>

      <!-- Right: Info -->
      <div class="col-md-9">
        <h2>John Doe</h2>
        <h5 class="text-muted">Senior Mathematics Teacher</h5>
        <p>Experienced teacher passionate about helping students excel in mathematics and science.</p>
      </div>
    </div>
  </div>

  <!-- Classes Card -->
  <div class="card mb-4">
    <div class="card-header">
      <h3 class="card-title">Classes</h3>
    </div>
    <div class="card-body">
      <ul>
        <li>Class 9 - Section A</li>
        <li>Class 10 - Section B</li>
      </ul>
    </div>
  </div>

  <!-- Attendance Card -->
  <div class="card mb-4">
    <div class="card-header">
      <h3 class="card-title">Attendance</h3>
    </div>
    <div class="card-body">
      <p>Present: 95%</p>
      <p>Absent: 3%</p>
      <p>Late: 2%</p>
    </div>
  </div>

</div>

<?= $this->endSection() ?>

