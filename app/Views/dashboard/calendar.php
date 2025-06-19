<?php
// app/Views/calendar.php
?>
<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Event Calendar</h5>
                    <button class="btn btn-light btn-sm" data-toggle="modal" data-target="#addEventModal">
                        <i class="fas fa-plus"></i> Add Event
                    </button>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="eventForm">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Event</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Start Date</label>
                        <input type="date" name="start" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>End Date</label>
                        <input type="date" name="end" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Color</label>
                        <input type="color" name="color" class="form-control" value="#007bff">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
        events: '/calendar/events',
        eventClick: function (info) {
            alert(info.event.title + "\n\n" + (info.event.extendedProps.description || ''));
        }
    });

    calendar.render();

    // Handle event form submission
    document.getElementById('eventForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('/calendar/add', {
            method: 'POST',
            body: formData
        }).then(res => res.json())
          .then(response => {
            if (response.status === 'success') {
                $('#addEventModal').modal('hide');
                calendar.refetchEvents();
            }
          });
    });
});
</script>

<?= $this->endSection() ?>
