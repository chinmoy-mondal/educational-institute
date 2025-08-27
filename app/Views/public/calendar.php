<?= $this->extend('layouts/base') ?>
<?= $this->section('content') ?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">School Name</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('/') ?>">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="<?= base_url('publiccalendar') ?>">Calendar</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('about') ?>">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('contact') ?>">Contact</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Calendar -->
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">School Event Calendar</h5>
        </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 650,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      events: '<?= base_url('publiccalendar/events') ?>',
      eventClick: function(info) {
        alert(
          "Title: " + info.event.title + "\n\n" +
          "Description: " + (info.event.extendedProps.description || '') + "\n" +
          "Start: " + info.event.start.toLocaleString() + "\n" +
          "End: " + (info.event.end ? info.event.end.toLocaleString() : '') + "\n" +
          "Category: " + (info.event.extendedProps.category || '') + "\n" +
          "Subcategory: " + (info.event.extendedProps.subcategory || '') + "\n" +
          "Class: " + (info.event.extendedProps.class || '') + "\n" +
          "Subject: " + (info.event.extendedProps.subject || '')
        );
      }
    });
    calendar.render();
  });
</script>

<?= $this->endSection() ?>