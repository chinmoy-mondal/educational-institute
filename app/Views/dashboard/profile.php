<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">

  <!-- Profile Card with Ribbon -->
  <div class="card position-relative mb-4" style="padding: 20px;">
    <div class="ribbon-wrapper ribbon-lg">
      <div class="ribbon bg-success text-lg">Active</div>
    </div>
    <div class="row align-items-center">
      <div class="col-md-3 text-center">
        <img src="https://via.placeholder.com/150" alt="Teacher Photo" class="img-fluid img-circle" style="max-width:150px;">
      </div>
      <div class="col-md-9">
        <h2>John Doe</h2>
        <h5 class="text-muted">Senior Mathematics Teacher</h5>
        <p>Experienced teacher passionate about helping students excel in mathematics and science.</p>
      </div>
    </div>
  </div>

  <!-- 3 Cards in a row -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Classes</h3></div>
        <div class="card-body">
          <ul>
            <li>Class 9 - Section A</li>
            <li>Class 10 - Section B</li>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Attendance</h3></div>
        <div class="card-body">
          <p>Present: 95%</p>
          <p>Absent: 3%</p>
          <p>Late: 2%</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Payments</h3></div>
        <div class="card-body">
          <p>Paid: $1200</p>
          <p>Pending: $300</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom row: Calendar and Graph -->
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Calendar</h3></div>
        <div class="card-body">
          <div id="calendar" style="height: 300px; background: #f4f6f9; display:flex; align-items:center; justify-content:center;">
            Calendar placeholder
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header"><h3 class="card-title">Graph</h3></div>
        <div class="card-body">
          <canvas id="chart" style="height: 300px;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chart').getContext('2d');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
      datasets: [{
        label: 'Attendance %',
        data: [95, 90, 93, 97, 92],
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, max: 100 }
      }
    }
  });
</script>

<?= $this->endSection() ?>

