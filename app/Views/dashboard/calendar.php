<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Event Calendar</h5>
          <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
            <i class="fas fa-plus"></i> Add Event
          </button>
        </div>
        <div class="card-body">
          <div id="alert-placeholder"></div>
          <div id="calendar"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="eventForm">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        <div class="modal-header">
          <h5 class="modal-title">Add New Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Category</label>
            <select name="category" id="add-category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="Exam">Exam</option>
              <option value="Notice">Notice</option>
              <option value="Holiday">Holiday</option>
              <option value="Vacation">Vacation</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Sub Category</label>
            <select name="subcategory" id="add-subcategory" class="form-control">
              <option value="">Select Sub Category</option>
            </select>
          </div>

          <div class="form-group mb-3" id="add-class-group">
            <label>Class</label>
            <select name="class" id="add-class" class="form-control">
              <option value="">Select Class</option>
              <option value="6">Class 6</option>
              <option value="7">Class 7</option>
              <option value="8">Class 8</option>
              <option value="9">Class 9</option>
              <option value="10">Class 10</option>
            </select>
          </div>

          <div class="form-group mb-3" id="add-subject-group">
            <label>Subject</label>
            <select name="subject" id="add-subject" class="form-control">
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= esc($subject['id']) ?>" data-class="<?= esc($subject['class']) ?>">
                  <?= esc($subject['class']) ?> - <?= esc($subject['subject']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Start Date & Time</label>
            <input type="date" name="start_date" class="form-control mb-2" required>
            <input type="time" name="start_time" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>End Date & Time</label>
            <input type="date" name="end_date" class="form-control mb-2" required>
            <input type="time" name="end_time" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Color</label>
            <input type="color" name="color" class="form-control" value="#007bff">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editEventModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editEventForm">
        <input type="hidden" name="id" id="edit-id">
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        <div class="modal-header">
          <h5 class="modal-title">Edit Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label>Title</label>
            <input type="text" name="title" id="edit-title" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Description</label>
            <textarea name="description" id="edit-description" class="form-control"></textarea>
          </div>

          <div class="form-group mb-3">
            <label>Category</label>
            <select name="category" id="edit-category" class="form-control" required>
              <option value="">Select Category</option>
              <option value="Exam">Exam</option>
              <option value="Notice">Notice</option>
              <option value="Holiday">Holiday</option>
              <option value="Vacation">Vacation</option>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Sub Category</label>
            <select name="subcategory" id="edit-subcategory" class="form-control">
              <option value="">Select Sub Category</option>
            </select>
          </div>

          <div class="form-group mb-3" id="edit-class-group">
            <label>Class</label>
            <select name="class" id="edit-class" class="form-control">
              <option value="">Select Class</option>
              <option value="6">Class 6</option>
              <option value="7">Class 7</option>
              <option value="8">Class 8</option>
              <option value="9">Class 9</option>
              <option value="10">Class 10</option>
            </select>
          </div>

          <div class="form-group mb-3" id="edit-subject-group">
            <label>Subject</label>
            <select name="subject" id="edit-subject" class="form-control">
              <option value="">Select Subject</option>
              <?php foreach ($subjects as $subject): ?>
                <option value="<?= esc($subject['id']) ?>" data-class="<?= esc($subject['class']) ?>">
                  <?= esc($subject['class']) ?> - <?= esc($subject['subject']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group mb-3">
            <label>Start Date & Time</label>
            <input type="date" name="start_date" id="edit-start-date" class="form-control mb-2" required>
            <input type="time" name="start_time" id="edit-start-time" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>End Date & Time</label>
            <input type="date" name="end_date" id="edit-end-date" class="form-control mb-2" required>
            <input type="time" name="end_time" id="edit-end-time" class="form-control" required>
          </div>

          <div class="form-group mb-3">
            <label>Color</label>
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

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
        const e = info.event;
        document.getElementById('edit-id').value = e.id;
        document.getElementById('edit-title').value = e.title || '';
        document.getElementById('edit-description').value = e.extendedProps.description || '';
        document.getElementById('edit-color').value = e.backgroundColor || '#007bff';
        document.getElementById('edit-category').value = e.extendedProps.category || '';
        document.getElementById('edit-subcategory').value = e.extendedProps.subcategory || '';
        document.getElementById('edit-class').value = e.extendedProps.class || '';
        document.getElementById('edit-subject').value = e.extendedProps.subject || '';

        if (e.start) {
          const s = new Date(e.start);
          document.getElementById('edit-start-date').value = s.toISOString().slice(0, 10);
          document.getElementById('edit-start-time').value = s.toTimeString().slice(0, 5);
        }
        if (e.end) {
          const en = new Date(e.end);
          document.getElementById('edit-end-date').value = en.toISOString().slice(0, 10);
          document.getElementById('edit-end-time').value = en.toTimeString().slice(0, 5);
        }

        new bootstrap.Modal(document.getElementById('editEventModal')).show();
      }
    });

    calendar.render();

    // 🔹 Helper to show alerts
    function showAlert(msg, type = 'success') {
      const div = document.createElement('div');
      div.className = `alert alert-${type} alert-dismissible fade show`;
      div.role = 'alert';
      div.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      document.getElementById('alert-placeholder').appendChild(div);
      setTimeout(() => div.remove(), 3500);
    }

    // 🔹 Helper: send form via AJAX
    async function sendForm(formId, url, modalId, successMsg) {
      const form = document.getElementById(formId);
      const btn = form.querySelector('button[type="submit"]');
      btn.disabled = true;

      try {
        const fd = new FormData(form);
        const res = await fetch(url, {
          method: 'POST',
          body: fd
        });
        const data = await res.json();

        if (data.status === 'success') {
          // ✅ Close popup modal automatically
          const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
          if (modal) modal.hide();

          form.reset();
          calendar.refetchEvents();
          showAlert(successMsg, 'success');
        } else {
          showAlert(data.message || 'Failed. Check form or server.', 'danger');
        }
      } catch (err) {
        console.error('Error:', err);
        showAlert('Error submitting form. See console.', 'danger');
      } finally {
        btn.disabled = false;
      }
    }

    // 🔹 Add event
    document.getElementById('eventForm')?.addEventListener('submit', e => {
      e.preventDefault();
      sendForm('eventForm', '/calendar/add', 'addEventModal', 'Event added successfully!');
    });

    // 🔹 Update event
    document.getElementById('editEventForm')?.addEventListener('submit', e => {
      e.preventDefault();
      sendForm('editEventForm', '/calendar/update', 'editEventModal', 'Event updated successfully!');
    });

    // 🔹 Delete event
    document.getElementById('deleteEvent')?.addEventListener('click', async () => {
      const id = document.getElementById('edit-id').value;
      if (!id) return showAlert('No event selected.', 'danger');

      const fd = new FormData();
      fd.append('id', id);

      const res = await fetch('/calendar/delete', {
        method: 'POST',
        body: fd
      });
      const data = await res.json();

      if (data.status === 'success') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editEventModal'));
        if (modal) modal.hide();
        calendar.refetchEvents();
        showAlert('Event deleted successfully!', 'success');
      } else {
        showAlert('Delete failed.', 'danger');
      }
    });
  });
</script>

<?= $this->endSection() ?>