<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header"); ?>
</div>

<div class="container content mt-5 pt-5">
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

<!-- FullCalendar -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Custom Calendar Styling -->
<style>
    /* White text inside calendar events */
    .fc-event,
    .fc-event-title,
    .fc-event-time {
        color: #fff !important;
    }

    /* Add rounded corners & soft shadow */
    .fc-event {
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        padding: 2px 4px;
        font-weight: 500;
    }

    /* Optional: highlight today's date */
    .fc-day-today {
        background-color: #eaf4ff !important;
    }
</style>

<!-- Event Modal -->
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
                <p><strong>Subcategory:</strong> <span id="modal-subcategory"></span></p>
                <p><strong>Class:</strong> <span id="modal-class"></span></p>
                <p><strong>Subject:</strong> <span id="modal-subject"></span></p>
                <p><strong>Start:</strong> <span id="modal-start"></span></p>
                <p><strong>End:</strong> <span id="modal-end"></span></p>
            </div>
        </div>
    </div>
</div>

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
            events: '<?= base_url('public-calendar/events') ?>',
            eventContent: function(arg) {
                // Custom render for event content
                const titleEl = document.createElement('div');
                titleEl.innerHTML = `<strong>${arg.event.title}</strong>`;

                const category = arg.event.extendedProps.category || '';
                const eventClass = arg.event.extendedProps.event_class || '';

                // Optional: only show if available
                let details = '';
                if (category || eventClass) {
                    details = `<small style="font-size: 11px; opacity: 0.9;">${category}${category && eventClass ? ' • ' : ''}${eventClass}</small>`;
                }

                const detailEl = document.createElement('div');
                detailEl.innerHTML = details;

                return {
                    domNodes: [titleEl, detailEl]
                };
            },
            eventDidMount: function(info) {
                // Style each event box
                info.el.style.borderLeft = "5px solid " + (info.event.backgroundColor || "#0d6efd");
                info.el.style.backgroundColor = info.event.backgroundColor || "#0d6efd";
                info.el.style.color = "#fff";
                info.el.style.borderRadius = "6px";
                info.el.style.padding = "2px 4px";
                info.el.style.boxShadow = "0 2px 5px rgba(0,0,0,0.15)";
            },
            eventClick: function(info) {
                const event = info.event;

                document.getElementById("modal-title").innerText = event.title || "";
                document.getElementById("modal-desc").innerText = event.extendedProps.description || "";
                document.getElementById("modal-category").innerText = event.extendedProps.category || "";
                document.getElementById("modal-subcategory").innerText = event.extendedProps.subcategory || "";
                document.getElementById("modal-class").innerText = event.extendedProps.event_class || "";
                document.getElementById("modal-subject").innerText = event.extendedProps.subject || "";

                const start = event.start ? event.start.toLocaleString() : '';
                const end = event.end ? event.end.toLocaleString() : '';

                document.getElementById("modal-start").innerText = start;
                document.getElementById("modal-end").innerText = end;

                new bootstrap.Modal(document.getElementById('eventModal')).show();
            }
        });
        calendar.render();
    });
</script>

<?= $this->endSection(); ?>