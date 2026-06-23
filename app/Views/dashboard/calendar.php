<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Event Calendar</h5>
        </div>

        <div class="card-body">
            <div id="calendar"></div>
        </div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {

        initialView: 'dayGridMonth',
        height: 650,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listMonth'
        },

        // ✅ IMPORTANT ROUTE (your admin route)
        events: '<?= base_url("admin/public-calendar/events") ?>',

        eventDidMount: function(info) {
            info.el.style.backgroundColor = info.event.backgroundColor || '#0d6efd';
            info.el.style.color = '#fff';
            info.el.style.borderRadius = '6px';
            info.el.style.padding = '3px';
        }

    });

    calendar.render();

});
</script>

<?= $this->endSection() ?>