<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Event Calendar</h5>
        </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Event Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- large size -->
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Title:</strong> <span id="eventTitle"></span></p>
        <p><strong>Description:</strong> <span id="eventDescription"></span></p>
        <p><strong>Start:</strong> <span id="eventStart"></span></p>
        <p><strong>End:</strong> <span id="eventEnd"></span></p>
        <p><strong>Category:</strong> <span id="eventCategory"></span></p>
        <p><strong>Subcategory:</strong> <span id="eventSubcategory"></span></p>
        <p><strong>Class:</strong> <span id="eventClass"></span></p>
        <p><strong>Subject:</strong> <span id="eventSubject"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

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
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      events: <?= json_encode($events) ?>,

      eventClick: function(info) {
        document.getElementById('eventTitle').innerText = info.event.title;
        document.getElementById('eventDescription').innerText = info.event.extendedProps.description || '';
        document.getElementById('eventStart').innerText = info.event.start ? info.event.start.toLocaleString() : '';
        document.getElementById('eventEnd').innerText = info.event.end ? info.event.end.toLocaleString() : '';
        document.getElementById('eventCategory').innerText = info.event.extendedProps.category || '';
        document.getElementById('eventSubcategory').innerText = info.event.extendedProps.subcategory || '';
        document.getElementById('eventClass').innerText = info.event.extendedProps.class || '';
        document.getElementById('eventSubject').innerText = info.event.extendedProps.subject || '';

        // Show modal
        let eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
        eventModal.show();
      }
    });

    calendar.render();
  });
</script>

<?= $this->endSection() ?>