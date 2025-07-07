<!-- chinmoy is testing calendar page only -->

<?= $this->include("../layouts/base-structure/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("../layouts/base-structure/header"); ?>
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

<?= $this->include("../layouts/base-structure/footer"); ?>

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Calendar Init -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 600,
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },
        events: '/public-calendar/events', // Make sure this route returns JSON
        eventClick: function (info) {
            alert(info.event.title + "\n\n" + (info.event.extendedProps.description || ''));
        }
    });

    calendar.render();
});
</script>

<?= $this->endSection(); ?>
