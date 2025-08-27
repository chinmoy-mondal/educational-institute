<!-- chinmoy is testing calendar page only -->

<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content"> <!-- offset for fixed navbar -->

    <!-- Start: Calendar Section -->
    <section class="calendar-section py-5 bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <h2 class="fw-bold">📅 School Event Calendar</h2>
                <p class="text-muted">Stay updated with holidays, exams, meetings and more.</p>
            </div>
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

</div>

<?= $this->include("layouts/base-structure/footer"); ?>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Event Details Modal -->
<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Event Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Title:</strong> <span id="modal-title"></span></p>
                <p><strong>Description:</strong> <span id="modal-desc"></span></p>
                <p><strong>Category:</strong> <span id="modal-category"></span></p>
                <p><strong>Class:</strong> <span id="modal-class"></span></p>
                <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                <p><strong>Date:</strong> <span id="modal-date"></span></p>
                <p><strong>Start Time:</strong> <span id="modal-start"></span></p>
                <p><strong>End Time:</strong> <span id="modal-end"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Calendar Init -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 650,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listMonth'
            },
            events: '/calendar/events', // JSON feed
            eventDidMount: function(info) {
                // style: left color ribbon
                info.el.style.borderLeft = "5px solid " + (info.event.backgroundColor || "#0d6efd");
                info.el.style.backgroundColor = "#2984e0ff";
            },
            eventClick: function(info) {
                // Format date and time separately
                let startDate = info.event.start ? info.event.start.toLocaleDateString() : "";
                let startTime = info.event.start ? info.event.start.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : "";
                let endTime = info.event.end ? info.event.end.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                }) : "";

                // Populate modal
                document.getElementById("modal-title").innerText = info.event.title || "";
                document.getElementById("modal-desc").innerText = info.event.extendedProps.subject || "";
                document.getElementById("modal-subject").innerText = info.event.extendedProps.color || "dfsdfsdf";
                document.getElementById("modal-date").innerText = startDate;
                document.getElementById("modal-start").innerText = startTime;
                document.getElementById("modal-end").innerText = endTime;

                // Show modal
                new bootstrap.Modal(document.getElementById('eventModal')).show();
            }
        });

        calendar.render();
    });
</script>

<?= $this->endSection(); ?>