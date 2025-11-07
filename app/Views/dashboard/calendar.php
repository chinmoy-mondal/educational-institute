<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow border-0 rounded-3">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Event Calendar</h5>
          <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#addEventModal">
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

<!-- JS Libraries -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function() {
    // ---------- Calendar ----------
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
        setValue('#edit-id', e.id || '');
        setValue('#edit-title', e.title || '');
        setValue('#edit-description', (e.extendedProps && e.extendedProps.description) || '');
        setValue('#edit-color', e.backgroundColor || '#007bff');
        setValue('#edit-category', (e.extendedProps && e.extendedProps.category) || '');
        setValue('#edit-subcategory', (e.extendedProps && e.extendedProps.subcategory) || '');
        setValue('#edit-class', (e.extendedProps && e.extendedProps.class) || '');
        setValue('#edit-subject', (e.extendedProps && e.extendedProps.subject) || '');
        if (e.start) {
          const s = new Date(e.start);
          setValue('#edit-start-date', s.toISOString().slice(0, 10));
          setValue('#edit-start-time', s.toTimeString().slice(0, 5));
        }
        if (e.end) {
          const en = new Date(e.end);
          setValue('#edit-end-date', en.toISOString().slice(0, 10));
          setValue('#edit-end-time', en.toTimeString().slice(0, 5));
        }
        const editModalEl = document.getElementById('editEventModal');
        const editModal = new bootstrap.Modal(editModalEl);
        editModal.show();
        handleCategoryChange(document.getElementById('edit-category').value, 'edit');
      }
    });
    calendar.render();

    function setValue(selector, value) {
      const el = document.querySelector(selector);
      if (!el) return;
      el.value = value;
    }

    function showAlert(msg, type = 'success') {
      const placeholder = document.getElementById('alert-placeholder');
      const div = document.createElement('div');
      div.className = `alert alert-${type} alert-dismissible fade show`;
      div.role = 'alert';
      div.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      placeholder.appendChild(div);
      setTimeout(() => div.remove(), 3500);
    }

    // Subcategory options
    const subOptions = {
      Exam: ['Half Yearly Exam', 'Annual Exam', 'Pre-Test Exam', 'Test Exam'],
      Holiday: ['Independence Day', 'Victory Day', 'Pohela Boishakh', 'Eid-ul-Fitr', 'Eid-ul-Adha', 'Christmas Day'],
      Notice: ['General Notice', 'Exam Notice', 'Holiday Notice'],
      Vacation: ['Summer Vacation', 'Winter Vacation']
    };

    function updateSubcategoryOptions(category, selectId) {
      const sel = document.getElementById(selectId);
      if (!sel) return;
      sel.innerHTML = '<option value="">Select Sub Category</option>';
      const arr = subOptions[category];
      if (arr) arr.forEach(v => sel.appendChild(new Option(v, v)));
    }

    function handleCategoryChange(category, prefix) {
      const classGroup = document.getElementById(prefix + '-class-group');
      const subjGroup = document.getElementById(prefix + '-subject-group');
      if (category === 'Holiday') {
        classGroup.style.display = 'none';
        subjGroup.style.display = 'none';
      } else {
        classGroup.style.display = '';
        subjGroup.style.display = '';
      }
      updateSubcategoryOptions(category, prefix + '-subcategory');
    }

    document.getElementById('add-category')?.addEventListener('change', e => handleCategoryChange(e.target.value, 'add'));
    document.getElementById('edit-category')?.addEventListener('change', e => handleCategoryChange(e.target.value, 'edit'));

    function filterSubjectOptions(classSelectorId, subjectSelectorId) {
      const classVal = document.getElementById(classSelectorId).value;
      const subjEl = document.getElementById(subjectSelectorId);
      Array.from(subjEl.options).forEach(opt => {
        opt.style.display = (!opt.value || !opt.dataset.class || opt.dataset.class == classVal) ? '' : 'none';
      });
    }

    document.getElementById('add-class')?.addEventListener('change', () => filterSubjectOptions('add-class', 'add-subject'));
    document.getElementById('edit-class')?.addEventListener('change', () => filterSubjectOptions('edit-class', 'edit-subject'));

    async function fetchJson(url, options = {}) {
      options.credentials = options.credentials || 'same-origin';
      options.headers = options.headers || {};
      if (!options.headers['Accept']) options.headers['Accept'] = 'application/json';
      const res = await fetch(url, options);
      const text = await res.text();
      try {
        return {
          ok: res.ok,
          status: res.status,
          data: JSON.parse(text),
          raw: text
        };
      } catch {
        return {
          ok: res.ok,
          status: res.status,
          data: null,
          raw: text
        };
      }
    }

    // ---------- Add Event ----------
    document.getElementById('eventForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = this.querySelector('button[type="submit"]');
      btn.disabled = true;
      const fd = new FormData(this);
      try {
        const result = await fetchJson('/calendar/add', {
          method: 'POST',
          body: fd
        });
        if (result.data?.status === 'success') {
          const modalEl = document.getElementById('addEventModal');
          const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
          modal.hide();
          this.reset();
          calendar.refetchEvents();
          showAlert('Event added successfully!', 'success');
        } else {
          showAlert('Failed to add event: ' + (result.data?.message || result.raw), 'danger');
        }
      } catch (err) {
        showAlert('Network error. See console.', 'danger');
        console.error(err);
      } finally {
        btn.disabled = false;
      }
    });

    // ---------- Edit Event ----------
    document.getElementById('editEventForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = this.querySelector('button[type="submit"]');
      btn.disabled = true;
      const fd = new FormData(this);
      try {
        const result = await fetchJson('/calendar/update', {
          method: 'POST',
          body: fd
        });
        if (result.data?.status === 'success') {
          const modalEl = document.getElementById('editEventModal');
          const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
          modal.hide();
          calendar.refetchEvents();
          showAlert('Event updated successfully!', 'success');
        } else {
          showAlert('Failed to update event: ' + (result.data?.message || result.raw), 'danger');
        }
      } catch (err) {
        showAlert('Network error. See console.', 'danger');
        console.error(err);
      } finally {
        btn.disabled = false;
      }
    });

    // ---------- Delete Event ----------
    document.getElementById('deleteEvent')?.addEventListener('click', async function() {
      const id = document.getElementById('edit-id').value;
      if (!id) {
        showAlert('No event id selected', 'danger');
        return;
      }
      const params = new URLSearchParams();
      params.append('id', id);
      Array.from(document.getElementById('editEventForm').querySelectorAll('input[type="hidden"]')).forEach(i => i.name && i.value && params.append(i.name, i.value));
      try {
        const result = await fetchJson('/calendar/delete', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: params.toString()
        });
        if (result.data?.status === 'success') {
          const modalEl = document.getElementById('editEventModal');
          const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
          modal.hide();
          calendar.refetchEvents();
          showAlert('Event deleted successfully!', 'success');
        } else showAlert('Failed to delete: ' + (result.data?.message || result.raw), 'danger');
      } catch (err) {
        showAlert('Network error. See console.', 'danger');
        console.error(err);
      }
    });
  });
</script> -->

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
        setValue('#edit-id', e.id || '');
        setValue('#edit-title', e.title || '');
        setValue('#edit-description', e.extendedProps?.description || '');
        setValue('#edit-color', e.backgroundColor || '#007bff');
        setValue('#edit-category', e.extendedProps?.category || '');
        setValue('#edit-subcategory', e.extendedProps?.subcategory || '');
        setValue('#edit-class', e.extendedProps?.class || '');
        setValue('#edit-subject', e.extendedProps?.subject || '');
        if (e.start) {
          const s = new Date(e.start);
          setValue('#edit-start-date', s.toISOString().slice(0, 10));
          setValue('#edit-start-time', s.toTimeString().slice(0, 5));
        }
        if (e.end) {
          const en = new Date(e.end);
          setValue('#edit-end-date', en.toISOString().slice(0, 10));
          setValue('#edit-end-time', en.toTimeString().slice(0, 5));
        }
        const editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
        editModal.show();
        handleCategoryChange(document.getElementById('edit-category').value, 'edit');
      }
    });
    calendar.render();

    function setValue(sel, val) {
      const el = document.querySelector(sel);
      if (el) el.value = val;
    }

    function showAlert(msg, type = 'success') {
      const placeholder = document.getElementById('alert-placeholder');
      const div = document.createElement('div');
      div.className = `alert alert-${type} alert-dismissible fade show`;
      div.role = 'alert';
      div.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
      placeholder.appendChild(div);
      setTimeout(() => div.remove(), 3500);
    }

    const subOptions = {
      Exam: ['Half Yearly Exam', 'Annual Exam', 'Pre-Test Exam', 'Test Exam'],
      Holiday: ['Independence Day', 'Victory Day', 'Pohela Boishakh', 'Eid-ul-Fitr', 'Eid-ul-Adha', 'Christmas Day'],
      Notice: ['General Notice', 'Exam Notice', 'Holiday Notice'],
      Vacation: ['Summer Vacation', 'Winter Vacation']
    };

    function updateSubcategoryOptions(category, selectId) {
      const sel = document.getElementById(selectId);
      sel.innerHTML = '<option value="">Select Sub Category</option>';
      const arr = subOptions[category];
      if (arr) arr.forEach(v => sel.appendChild(new Option(v, v)));
    }

    function handleCategoryChange(category, prefix) {
      const classGroup = document.getElementById(prefix + '-class-group');
      const subjGroup = document.getElementById(prefix + '-subject-group');
      if (category === 'Holiday') {
        classGroup.style.display = 'none';
        subjGroup.style.display = 'none';
      } else {
        classGroup.style.display = '';
        subjGroup.style.display = '';
      }
      updateSubcategoryOptions(category, prefix + '-subcategory');
    }

    document.getElementById('add-category')?.addEventListener('change', e => handleCategoryChange(e.target.value, 'add'));
    document.getElementById('edit-category')?.addEventListener('change', e => handleCategoryChange(e.target.value, 'edit'));

    function filterSubjectOptions(classSelectorId, subjectSelectorId) {
      const classVal = document.getElementById(classSelectorId).value;
      const subjEl = document.getElementById(subjectSelectorId);
      Array.from(subjEl.options).forEach(opt => {
        opt.style.display = (!opt.value || !opt.dataset.class || opt.dataset.class == classVal) ? '' : 'none';
      });
    }

    document.getElementById('add-class')?.addEventListener('change', () => filterSubjectOptions('add-class', 'add-subject'));
    document.getElementById('edit-class')?.addEventListener('change', () => filterSubjectOptions('edit-class', 'edit-subject'));

    async function fetchJson(url, options = {}) {
      options.credentials = 'same-origin';
      options.headers = {
        Accept: 'application/json',
        ...(options.headers || {})
      };
      const res = await fetch(url, options);
      const text = await res.text();
      try {
        return {
          ok: res.ok,
          data: JSON.parse(text)
        };
      } catch {
        return {
          ok: res.ok,
          data: null
        };
      }
    }

    // Add Event
    document.getElementById('eventForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = this.querySelector('button[type="submit"]');
      btn.disabled = true;
      const fd = new FormData(this);
      const result = await fetchJson('/calendar/add', {
        method: 'POST',
        body: fd
      });
      if (result.data?.status === 'success') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('addEventModal'));
        if (modal) modal.hide();
        this.reset();
        calendar.refetchEvents();
        showAlert('Event added successfully!');
      } else {
        showAlert('Failed to add event', 'danger');
      }
      btn.disabled = false;
    });

    // Update Event
    document.getElementById('editEventForm')?.addEventListener('submit', async function(e) {
      e.preventDefault();
      const btn = this.querySelector('button[type="submit"]');
      btn.disabled = true;

      const fd = new FormData(this);
      const result = await fetchJson('/calendar/update', {
        method: 'POST',
        body: fd
      });

      if (result.data?.status === 'success') {
        // Hide the modal
        const modalEl = document.getElementById('editEventModal');
        const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
        modal.hide();

        // Refetch events in the calendar
        calendar.refetchEvents();

        // Show success alert
        showAlert('Event updated successfully!');
      } else {
        showAlert('Failed to update event', 'danger');
      }

      btn.disabled = false;
    });

    // Delete Event
    document.getElementById('deleteEvent')?.addEventListener('click', async function() {
      const id = document.getElementById('edit-id').value;
      if (!id) return showAlert('No event selected', 'danger');
      const params = new URLSearchParams();
      params.append('id', id);
      Array.from(document.querySelectorAll('#editEventForm input[type="hidden"]')).forEach(i => i.name && params.append(i.name, i.value));
      const result = await fetchJson('/calendar/delete', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: params.toString()
      });
      if (result.data?.status === 'success') {
        const modal = bootstrap.Modal.getInstance(document.getElementById('editEventModal'));
        if (modal) modal.hide();
        calendar.refetchEvents();
        showAlert('Event deleted successfully!');
      } else {
        showAlert('Failed to delete event', 'danger');
      }
    });
  });
</script>

<?= $this->endSection() ?>