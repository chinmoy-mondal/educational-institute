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
          <div class="form-group"><label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="form-group"><label>Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>
          <div class="form-group"><label>Category</label>
            <select name="category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="Exam">Exam</option>
              <option value="Notice">Notice</option>
              <option value="Holiday">Holiday</option>
              <option value="Vacation">Vacation</option>
            </select>
          </div>
          <div class="form-group"><label>Sub Category</label>
            <select name="subcategory" class="form-control">
              <option value="">Select Sub Category</option>
              <option value="Half Yearly Exam">Half Yearly Exam</option>
              <option value="Final Exam">Final Exam</option>
              <option value="Pre-Test Exam">Pre-Test Exam</option>
              <option value="Test Exam">Test Exam</option>
            </select>
          </div>
          <div class="form-group"><label>Class</label>
            <select name="class" class="form-control">
              <option value="">Select Class</option>
              <option value="6">Class 6</option>
              <option value="7">Class 7</option>
              <option value="8">Class 8</option>
              <option value="9">Class 9</option>
              <option value="10">Class 10</option>
            </select>
          </div>
          <div class="form-group">
            <label>Subject</label>
            <select name="subject" id="add-subject" class="form-control">
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= esc($subject['id']) ?>">
                  <?= esc($subject['id']) ?> - <?= esc($subject['subject']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group"><label>Start Date</label>
            <input type="date" name="start" class="form-control" required>
          </div>
          <div class="form-group"><label>End Date</label>
            <input type="date" name="end" class="form-control" required>
          </div>
          <div class="form-group"><label>Color</label>
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

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form id="editEventForm">
        <input type="hidden" name="id" id="edit-id">
        <div class="modal-header">
          <h5 class="modal-title">Edit Event</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group"><label>Title</label>
            <input type="text" name="title" id="edit-title" class="form-control" required>
          </div>
          <div class="form-group"><label>Description</label>
            <textarea name="description" id="edit-description" class="form-control"></textarea>
          </div>
          <div class="form-group"><label>Category</label>
            <select name="category" id="edit-category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="Exam">Exam</option>
              <option value="Notice">Notice</option>
              <option value="Holiday">Holiday</option>
              <option value="Vacation">Vacation</option>
            </select>
          </div>
          <div class="form-group"><label>Sub Category</label>
            <select name="subcategory" id="edit-subcategory" class="form-control">
              <option value="">Select Sub Category</option>
              <option value="Half Yearly Exam">Half Yearly Exam</option>
              <option value="Final Exam">Final Exam</option>
              <option value="Pre-Test Exam">Pre-Test Exam</option>
              <option value="Test Exam">Test Exam</option>
            </select>
          </div>
          <div class="form-group"><label>Class</label>
            <select name="class" id="edit-class" class="form-control">
              <option value="">Select Class</option>
              <option value="6">Class 6</option>
              <option value="7">Class 7</option>
              <option value="8">Class 8</option>
              <option value="9">Class 9</option>
              <option value="10">Class 10</option>
            </select>
          </div>
          <div class="form-group">
            <label>Subject</label>
            <select name="subject" id="edit-subject" class="form-control">
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= esc($subject['id']) ?>">
                  <?= esc($subject['id']) ?> - <?= esc($subject['subject']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group"><label>Start Date</label>
            <input type="date" name="start" id="edit-start" class="form-control" required>
          </div>
          <div class="form-group"><label>End Date</label>
            <input type="date" name="end" id="edit-end" class="form-control" required>
          </div>
          <div class="form-group"><label>Color</label>
            <input type="color" name="color" id="edit-color" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Update</button>
          <button type="button" class="btn btn-danger" id="deleteEvent">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
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
      events: '/calendar/events',

      eventClick: function(info) {
        const event = info.event;

        // Fill modal
        document.getElementById('edit-id').value = event.id;
        document.getElementById('edit-title').value = event.title;
        document.getElementById('edit-description').value = event.extendedProps.description || '';
        document.getElementById('edit-category').value = event.extendedProps.category || '';
        document.getElementById('edit-subcategory').value = event.extendedProps.subcategory || '';
        document.getElementById('edit-class').value = event.extendedProps.class || '';
        document.getElementById('edit-subject').value = event.extendedProps.subject || '';
        document.getElementById('edit-start').value = event.startStr.split('T')[0];
        document.getElementById('edit-end').value = event.endStr ? event.endStr.split('T')[0] : event.startStr.split('T')[0];
        document.getElementById('edit-color').value = event.backgroundColor || '#007bff';

        $('#editEventModal').modal('show');
      }
    });

    calendar.render();

    // Add
    document.getElementById('eventForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('/calendar/add', {
          method: 'POST',
          body: formData
        }).then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            $('#addEventModal').modal('hide');
            this.reset();
            calendar.refetchEvents();
          }
        });
    });

    // Update
    document.getElementById('editEventForm').addEventListener('submit', function(e) {
      e.preventDefault();
      const formData = new FormData(this);

      fetch('/calendar/update', {
          method: 'POST',
          body: formData
        }).then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            $('#editEventModal').modal('hide');
            calendar.refetchEvents();
          }
        });
    });

    // Delete
    document.getElementById('deleteEvent').addEventListener('click', function() {
      const id = document.getElementById('edit-id').value;

      fetch('/calendar/delete', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams({
            id
          })
        }).then(res => res.json())
        .then(response => {
          if (response.status === 'success') {
            $('#editEventModal').modal('hide');
            calendar.refetchEvents();
          }
        });
    });
  });
</script>

<?= $this->endSection() ?>