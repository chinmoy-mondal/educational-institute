<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
  <!-- Profile Card -->
  <div class="card card-primary card-outline mb-4 position-relative p-3">
    <div class="ribbon-wrapper ribbon-lg">
      <div class="ribbon bg-info text-white"><?= esc($user['role']) ?></div>
    </div>

    <div class="row">
      <!-- Left: Profile Picture + Doughnut -->
      <div class="col-md-3 d-flex flex-column align-items-center">
        <img class="profile-user-img img-fluid mb-2"
          src="<?= base_url('public/assets/img/headsir.jpg'); ?>"
          alt="Teacher Photo"
          style="width:150px; height:200px; object-fit:cover; border-radius:4px;">
        <h4 class="mt-2"><?= esc($user['name']) ?></h4>
        <p class="text-muted"><?= esc($user['designation']) ?></p>

      </div>

      <!-- Middle: User Info Section -->
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <dl class="row mb-0">
              <dt class="col-sm-4"><i class="fas fa-user-tag mr-2"></i>Role</dt>
              <dd class="col-sm-8"><?= esc($user['role']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-book mr-2"></i>Subject</dt>
              <dd class="col-sm-8"><?= esc($user['subject']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-venus-mars mr-2"></i>Gender</dt>
              <dd class="col-sm-8"><?= esc($user['gender']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-phone-alt mr-2"></i>Phone</dt>
              <dd class="col-sm-8"><?= esc($user['phone']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-envelope mr-2"></i>Email</dt>
              <dd class="col-sm-8"><?= esc($user['email']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-book-reader mr-2"></i>Assigned Subject</dt>
              <dd class="col-sm-8"><?= esc($user['assagin_sub']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-user-check mr-2"></i>Account Status</dt>
              <dd class="col-sm-8"><?= esc($user['account_status']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-user-shield mr-2"></i>Permit By</dt>
              <dd class="col-sm-8"><?= esc($user['permit_by']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-calendar-plus mr-2"></i>Created At</dt>
              <dd class="col-sm-8"><?= esc($user['created_at']) ?></dd>

              <dt class="col-sm-4"><i class="fas fa-calendar-check mr-2"></i>Updated At</dt>
              <dd class="col-sm-8"><?= esc($user['updated_at']) ?></dd>
            </dl>
          </div>
        </div>
      </div>

<!-- Middle: User Info Section -->
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            
        <div class="mt-3" style="width:150px; height:150px;">
          <canvas id="attendanceChart"></canvas>
        </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Info Cards -->
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

  <!-- Bottom Row: Calendar & Bar Chart -->
  <div class="row">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <h3 class="card-title">Calendar</h3>
        </div>
        <div class="card-body p-0">
          <div id="calendar" style="height:350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header">
          <h3 class="card-title">Monthly Attendance</h3>
        </div>
        <div class="card-body" style="height:350px;">
          <canvas id="chart" style="width:100%; height:100%;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Profile Doughnut Chart
    const ctxDoughnut = document.getElementById('attendanceChart').getContext('2d');
    new Chart(ctxDoughnut, {
      type: 'doughnut',
      data: {
        labels: ['Present', 'Absent', 'Leave'],
        datasets: [{
          data: [95, 3, 2],
          backgroundColor: ['rgba(54,162,235,0.7)', 'rgba(255,99,132,0.7)', 'rgba(255,206,86,0.7)'],
          borderColor: ['rgba(54,162,235,1)', 'rgba(255,99,132,1)', 'rgba(255,206,86,1)'],
          borderWidth: 1
        }]
      },
      options: {
        cutout: '70%',
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      }
    });

    // Bottom Bar Chart
    const ctxBar = document.getElementById('chart').getContext('2d');
    new Chart(ctxBar, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
        datasets: [{
          label: 'Attendance %',
          data: [95, 90, 93, 97, 92],
          backgroundColor: 'rgba(54,162,235,0.6)'
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });

    // FullCalendar
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: [{
          title: 'Exam',
          start: '2025-08-20'
        },
        {
          title: 'Meeting',
          start: '2025-08-18'
        }
      ]
    });
    calendar.render();
  });
</script>

<?= $this->endSection() ?>