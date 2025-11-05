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

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

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
            events: '<?= base_url('calendar/events') ?>',
            eventDidMount: function(info) {
                info.el.style.borderLeft = "5px solid " + (info.event.backgroundColor || "#0d6efd");
                info.el.style.backgroundColor = info.event.backgroundColor || "#cfe2ff";
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