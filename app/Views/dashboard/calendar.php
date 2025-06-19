<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Event Calendar</h5>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FullCalendar Script -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      height: 600,
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek'
      },
      events: [
        {
          title: 'Mid-Term Exam',
          start: '2025-06-21',
          description: 'Exams begin for classes 6-10.',
          color: '#f56954'
        },
        {
          title: 'Eid-ul-Adha Holiday',
          start: '2025-06-29',
          description: 'School closed.',
          color: '#00a65a'
        },
        {
          title: 'Parent-Teacher Meeting',
          start: '2025-07-03',
          description: 'Scheduled in Room 5.',
          color: '#f39c12'
        },
        {
          title: 'Results Published',
          start: '2025-07-10',
          color: '#0073b7'
        }
      ],
      eventClick: function (info) {
        alert(info.event.title + "\n\n" + (info.event.extendedProps.description || ''));
      }
    });

    calendar.render();
  });
</script>

<?= $this->endSection() ?>
