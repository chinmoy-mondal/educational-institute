<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content">

    <!-- Start: Calendar Section -->
    <section class="calendar-section py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">School Event Calendar</h2>
                <p class="text-muted">Stay updated with holidays, exams, and more.</p>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

</div>

<?= $this->include("layouts/base-structure/footer"); ?>

<!-- Event Details Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-3">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-bold" id="eventModalLabel">Event Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Title:</strong> <span id="eventTitle"></span></li>
          <li class="list-group-item"><strong>Description:</strong> <span id="eventDescription"></span></li>
          <li class="list-group-item"><strong>Date:</strong> <span id="eventDate"></span></li>
          <li class="list-group-item"><strong>Start Time:</strong> <span id="eventStartTime"></span></li>
          <li class="list-group-item"><strong>End Time:</strong> <span id="eventEndTime"></span></li>
          <li class="list-group-item"><strong>Category:</strong> <span id="eventCategory"></span></li>
          <li class="list-group-item"><strong>Subcategory:</strong> <span id="eventSubcategory"></span></li>
          <li class="list-group-item"><strong>Class:</strong> <span id="eventClass"></span></li>
          <li class="list-group-item"><strong>Subject:</strong> <span id="eventSubject"></span></li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Bootstrap JS (for modal) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Calendar Init -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            events: '/public-calendar/events', // Must return JSON

            eventClick: function(info) {
                const props = info.event.extendedProps;

                // Format date
                let startDate = info.event.start ? new Date(info.event.start) : null;
                let endDate   = info.event.end ? new Date(info.event.end) : null;

                let dateStr = "";
                if (startDate && endDate) {
                    // If event spans multiple days
                    if (startDate.toDateString() !== endDate.toDateString()) {
                        dateStr = startDate.toLocaleDateString() + " → " + endDate.toLocaleDateString();
                    } else {
                        dateStr = startDate.toLocaleDateString();
                    }
                } else if (startDate) {
                    dateStr = startDate.toLocaleDateString();
                }

                let startTime = startDate ? startDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                let endTime   = endDate ? endDate.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';

                // Fill modal fields
                document.getElementById('eventTitle').innerText = info.event.title || '';
                document.getElementById('eventDescription').innerText = props.description || '';
                document.getElementById('eventDate').innerText = dateStr;
                document.getElementById('eventStartTime').innerText = startTime;
                document.getElementById('eventEndTime').innerText = endTime;
                document.getElementById('eventCategory').innerText = props.category || '';
                document.getElementById('eventSubcategory').innerText = props.subcategory || '';
                document.getElementById('eventClass').innerText = props.class || '';
                document.getElementById('eventSubject').innerText = props.subject || '';

                // Show modal
                const eventModal = new bootstrap.Modal(document.getElementById('eventModal'));
                eventModal.show();
            }
        });

        calendar.render();
    });
</script>

<?= $this->endSection(); ?>