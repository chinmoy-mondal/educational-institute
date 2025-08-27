<?= $this->extend('layouts/base') ?> 
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">School Event Calendar</h5>
        </div>
        <div class="card-body">
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Event Details</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tr><th>Title</th><td id="detail-title"></td></tr>
          <tr><th>Description</th><td id="detail-description"></td></tr>
          <tr><th>Category</th><td id="detail-category"></td></tr>
          <tr><th>Sub Category</th><td id="detail-subcategory"></td></tr>
          <tr><th>Class</th><td id="detail-class"></td></tr>
          <tr><th>Subject</th><td id="detail-subject"></td></tr>
          <tr><th>Start</th><td id="detail-start"></td></tr>
          <tr><th>End</th><td id="detail-end"></td></tr>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- FullCalendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
      events: '/publiccalendar/events',

      eventClick: function(info) {
        const e = info.event;
        document.getElementById('detail-title').innerText       = e.title || '';
        document.getElementById('detail-description').innerText = e.extendedProps.description || '';
        document.getElementById('detail-category').innerText    = e.extendedProps.category || '';
        document.getElementById('detail-subcategory').innerText = e.extendedProps.subcategory || '';
        document.getElementById('detail-class').innerText       = e.extendedProps.class || '';
        document.getElementById('detail-subject').innerText     = e.extendedProps.subject || '';
        document.getElementById('detail-start').innerText       = e.start ? e.start.toLocaleString() : '';
        document.getElementById('detail-end').innerText         = e.end ? e.end.toLocaleString() : '';

        $('#eventDetailsModal').modal('show');
      }
    });

    calendar.render();
  });
</script>

<?= $this->endSection() ?>