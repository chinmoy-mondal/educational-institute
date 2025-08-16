<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
  <div class="row">
    <!-- Calendar -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">School Calendar</h5>
        </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <!-- Graph -->
    <div class="col-md-6 mb-4">
      <div class="card">
        <div class="card-header bg-success text-white">
          <h5 class="mb-0">Students Report</h5>
        </div>
        <div class="card-body">
          <canvas id="studentsChart"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Circle Progress -->
  <div class="row">
    <div class="col-md-4 text-center mb-4">
      <div id="circle1"></div>
      <p>Attendance</p>
    </div>
    <div class="col-md-4 text-center mb-4">
      <div id="circle2"></div>
      <p>Results</p>
    </div>
    <div class="col-md-4 text-center mb-4">
      <div id="circle3"></div>
      <p>Fees Collected</p>
    </div>
  </div>
</div>

<!-- JS Libraries -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/circles.js@0.0.6/circles.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  // FullCalendar
  var calendarEl = document.getElementById("calendar");
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    events: [
      { title: "Exam", start: "2025-08-20" },
      { title: "Holiday", start: "2025-08-25" }
    ]
  });
  calendar.render();

  // Chart.js
  var ctx = document.getElementById("studentsChart").getContext("2d");
  new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Class 6", "Class 7", "Class 8", "Class 9", "Class 10"],
      datasets: [{
        label: "No. of Students",
        data: [50, 45, 60, 55, 40],
        backgroundColor: "rgba(54, 162, 235, 0.6)"
      }]
    }
  });

  // Circles.js
  Circles.create({
    id: "circle1",
    radius: 60,
    value: 80,
    maxValue: 100,
    text: function(value){ return value + "%"; },
    colors: ["#eee", "#007bff"]
  });

  Circles.create({
    id: "circle2",
    radius: 60,
    value: 65,
    maxValue: 100,
    text: function(value){ return value + "%"; },
    colors: ["#eee", "#28a745"]
  });

  Circles.create({
    id: "circle3",
    radius: 60,
    value: 90,
    maxValue: 100,
    text: function(value){ return value + "%"; },
    colors: ["#eee", "#ffc107"]
  });
});
</script>

<?= $this->endSection() ?>