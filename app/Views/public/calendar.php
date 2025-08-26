<!-- chinmoy is testing calendar page only -->

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

<!-- FullCalendar CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

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
            events: '/public-calendar/events', // Make sure this route returns JSON
            eventClick: function(info) {
                const props = info.event.extendedProps;

                alert(
                    "Title: " + info.event.title + "\n\n" +
                    "Description: " + (props.description || '') + "\n\n" +
                    "Start Date: " + (props.start_date || '') + "\n" +
                    "Start Time: " + (props.start_time || '') + "\n\n" +
                    "End Date: " + (props.end_date || '') + "\n" +
                    "End Time: " + (props.end_time || '') + "\n\n" +
                    "Color: " + (props.color || '') + "\n\n" +
                    "Category: " + (props.category || '') + "\n" +
                    "Subcategory: " + (props.subcategory || '') + "\n" +
                    "Class: " + (props.class || '') + "\n" +
                    "Subject: " + (props.subject || '')
                );
            }
        });

        calendar.render();
    });
</script>

<?= $this->endSection(); ?>