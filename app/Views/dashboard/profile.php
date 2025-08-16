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
        <div class="position-relative" style="width:150px; height:200px;">
          <a href="<?= site_url('admin/students/edit-photo/' . $user['id']) ?>"
            class="position-absolute top-0 start-0 m-1 text-primary"
            title="Edit Photo">
            <i class="fas fa-edit"></i>
          </a>
          <img class="profile-user-img img-fluid mb-2"
            src="<?= base_url('public/assets/img/default-profile-pic.png'); ?>"
            alt="Teacher Photo"
            style="width:150px; height:200px; object-fit:cover; border-radius:4px;">
        </div>

        <h4 class="mt-2"><?= esc($user['name']) ?></h4>
        <p class="text-muted"><?= esc($user['designation']) ?></p>
      </div>

      <!-- Middle: User Info Section -->
      <div class="col-md-5">
        <div class="card h-100">
          <div class="card-body">
            <dl class="row mb-0">
              <dt class="col-sm-4">Role</dt>
              <dd class="col-sm-8"><?= esc($user['role']) ?></dd>
              <dt class="col-sm-4">Subject</dt>
              <dd class="col-sm-8"><?= esc($user['subject']) ?></dd>
              <dt class="col-sm-4">Gender</dt>
              <dd class="col-sm-8"><?= esc($user['gender']) ?></dd>
              <dt class="col-sm-4">Phone</dt>
              <dd class="col-sm-8"><?= esc($user['phone']) ?></dd>
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8"><?= esc($user['email']) ?></dd>
            </dl>
          </div>
        </div>
      </div>

      <!-- Right: Doughnut Chart -->
      <div class="col-md-4 d-flex align-items-center justify-content-center">
        <div style="width:200px; height:200px;">
          <canvas id="attendanceChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Row: Calendar & Bar Chart -->
  <div class="row">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header">Calendar</div>
        <div class="card-body p-0">
          <div id="calendar" style="height:350px;"></div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-header">Monthly Attendance</div>
        <div class="card-body" style="height:350px;">
          <canvas id="chart" style="width:100%; height:100%;"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->section('scripts') ?>
<!-- Load Libraries -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  // Doughnut Chart
  const ctxDoughnut = document.getElementById('attendanceChart').getContext('2d');
  new Chart(ctxDoughnut, {
    type: 'doughnut',
    data: {
      labels: ['Present', 'Absent', 'Leave'],
      datasets: [{
        data: [95,3,2],
        backgroundColor: ['rgba(54,162,235,0.7)','rgba(255,99,132,0.7)','rgba(255,206,86,0.7)'],
        borderColor: ['rgba(54,162,235,1)','rgba(255,99,132,1)','rgba(255,206,86,1)'],
        borderWidth: 1
      }]
    },
    options: {
      cutout: '70%',
      plugins: { legend: { display:true, position:'bottom' } }
    }
  });

  // Bar Chart
  const ctxBar = document.getElementById('chart').getContext('2d');
  new Chart(ctxBar, {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','May'],
      datasets: [{
        label:'Attendance %',
        data:[95,90,93,97,92],
        backgroundColor:'rgba(54,162,235,0.6)'
      }]
    },
    options:{ responsive:true, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true, max:100 } } }
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
    events:[
      { title:'Exam', start:'2025-08-20' },
      { title:'Meeting', start:'2025-08-18' }
    ]
  });
  calendar.render();
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>