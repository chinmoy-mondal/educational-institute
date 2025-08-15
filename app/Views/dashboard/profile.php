<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
<!-- Profile Card -->
<div class="card card-primary card-outline mb-4 position-relative p-3">
    <!-- Ribbon for Roll -->
    <div class="ribbon-wrapper ribbon-lg position-absolute" style="top:10px; right:-5px;">
        <div class="ribbon bg-info text-lg">
            Roll: 
        </div>
    </div>

    <div class="row align-items-center">
        <!-- Left: Profile Picture -->
        <div class="col-md-3 text-center">
            <img class="profile-user-img img-fluid img-circle mb-2"
                 src="<?= esc($user['photo'] ?? 'https://via.placeholder.com/150') ?>"
                 alt="Teacher Photo"
                 style="max-width:150px;">
            <h4 class="mt-2"><?= esc($user['name']) ?></h4>
            <p class="text-muted"><?= esc($user['designation']) ?></p>
        </div>

        <!-- Right: User Info Table -->
        <div class="col-md-9">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <tbody>
                        <tr>
                            <th><i class="fas fa-user-tag mr-2"></i> Role</th>
                            <td><?= esc($user['role']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-book mr-2"></i> Subject</th>
                            <td><?= esc($user['subject']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-venus-mars mr-2"></i> Gender</th>
                            <td><?= esc($user['gender']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-phone-alt mr-2"></i> Phone</th>
                            <td><?= esc($user['phone']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-envelope mr-2"></i> Email</th>
                            <td><?= esc($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-book-reader mr-2"></i> Assigned Subject</th>
                            <td><?= esc($user['assagin_sub']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-user-check mr-2"></i> Account Status</th>
                            <td><?= esc($user['account_status']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-user-shield mr-2"></i> Permit By</th>
                            <td><?= esc($user['permit_by']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-calendar-plus mr-2"></i> Created At</th>
                            <td><?= esc($user['created_at']) ?></td>
                        </tr>
                        <tr>
                            <th><i class="fas fa-calendar-check mr-2"></i> Updated At</th>
                            <td><?= esc($user['updated_at']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

  <!-- 3 Cards in a row -->
  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card">
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
    </div>

    <div class="col-md-4">
      <div class="card">
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

    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Payments</h3>
        </div>
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
        <div class="card-header">
          <h3 class="card-title">Calendar</h3>
        </div>
        <div class="card-body">
          <div id="calendar" style="height: 300px; background: #f4f6f9; display:flex; align-items:center; justify-content:center;">
            Calendar placeholder
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Graph</h3>
        </div>
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
        y: {
          beginAtZero: true,
          max: 100
        }
      }
    }
  });
</script>

<?= $this->endSection() ?>