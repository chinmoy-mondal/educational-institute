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
<script>
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
        // fill edit form
        setValue('#edit-id', e.id || '');
        setValue('#edit-title', e.title || '');
        setValue('#edit-description', (e.extendedProps && e.extendedProps.description) || '');
        setValue('#edit-color', e.backgroundColor || '#007bff');
        setValue('#edit-category', (e.extendedProps && e.extendedProps.category) || '');
        // trigger change to populate subcategory/class visibility (we trigger manually below)
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

        // show modal (Bootstrap 5)
        const editModalEl = document.getElementById('editEventModal');
        const editModal = new bootstrap.Modal(editModalEl);
        editModal.show();

        // ensure UI adjustments for category (if you have category-dependent hiding)
        handleCategoryChange(document.getElementById('edit-category').value, 'edit');
      }
    });
    calendar.render();

    // helper
    function setValue(selector, value) {
      const el = document.querySelector(selector);
      if (!el) return;
      el.value = value;
    }

    // ---------- alerts ----------
    function showAlert(msg, type = 'success') {
      const placeholder = document.getElementById('alert-placeholder');
      const div = document.createElement('div');
      div.className = `alert alert-${type} alert-dismissible fade show`;
      div.role = 'alert';
      div.innerHTML = `${msg} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`;
      placeholder.appendChild(div);
      setTimeout(() => {
        if (div) div.remove();
      }, 3500);
    }

    // ---------- subcategory & class/subject toggles ----------
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
      if (arr && arr.length) {
        arr.forEach(v => {
          const opt = document.createElement('option');
          opt.value = v;
          opt.textContent = v;
          sel.appendChild(opt);
        });
      }
    }

    function handleCategoryChange(category, prefix) {
      // hide class/subject for holidays
      const classGroup = document.getElementById(prefix + '-class-group');
      const subjGroup = document.getElementById(prefix + '-subject-group');
      if (classGroup && subjGroup) {
        if (category === 'Holiday') {
          classGroup.style.display = 'none';
          subjGroup.style.display = 'none';
        } else {
          classGroup.style.display = '';
          subjGroup.style.display = '';
        }
      }
      updateSubcategoryOptions(category, prefix + '-subcategory');
    }

    // wire category selects
    const addCat = document.getElementById('add-category');
    const editCat = document.getElementById('edit-category');
    if (addCat) addCat.addEventListener('change', function() {
      handleCategoryChange(this.value, 'add');
    });
    if (editCat) editCat.addEventListener('change', function() {
      handleCategoryChange(this.value, 'edit');
    });

    // subject filtering by class (works if <option data-class="6"> exists)
    function filterSubjectOptions(classSelectorId, subjectSelectorId) {
      const classEl = document.getElementById(classSelectorId);
      const subjEl = document.getElementById(subjectSelectorId);
      if (!classEl || !subjEl) return;
      const classVal = classEl.value;
      Array.from(subjEl.options).forEach(opt => {
        if (!opt.value) {
          opt.style.display = '';
          return;
        } // keep empty option visible
        const dataClass = opt.dataset.class || '';
        opt.style.display = (dataClass === '' || dataClass == classVal) ? '' : 'none';
      });
    }
    const addClassEl = document.getElementById('add-class');
    const editClassEl = document.getElementById('edit-class');
    if (addClassEl) addClassEl.addEventListener('change', () => filterSubjectOptions('add-class', 'add-subject'));
    if (editClassEl) editClassEl.addEventListener('change', () => filterSubjectOptions('edit-class', 'edit-subject'));

    // ---------- utility: robust fetch wrapper that logs responses ----------
    async function fetchJson(url, options = {}) {
      console.debug('Fetch request', url, options);
      // default: include credentials for same-origin (helps with cookie-based CSRF)
      options.credentials = options.credentials || 'same-origin';
      // Accept JSON
      options.headers = options.headers || {};
      if (!options.headers['Accept']) options.headers['Accept'] = 'application/json';

      const res = await fetch(url, options);
      const text = await res.text();
      // try parse JSON, otherwise return raw text
      try {
        const json = JSON.parse(text);
        console.debug('Fetch response JSON', json);
        return {
          ok: res.ok,
          status: res.status,
          data: json,
          raw: text
        };
      } catch (err) {
        console.warn('Server returned non-JSON response:', text);
        return {
          ok: res.ok,
          status: res.status,
          data: null,
          raw: text
        };
      }
    }

    // ---------- Add Event (plain JS) ----------
    const eventForm = document.getElementById('eventForm');
    if (eventForm) {
      eventForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        if (btn) {
          btn.disabled = true;
        }
        const fd = new FormData(this);
        // ensure times/dates are present set earlier in form or by UI
        try {
          const result = await fetchJson('/calendar/add', {
            method: 'POST',
            body: fd
          });
          console.debug('Add result', result);
          if (result.data && result.data.status === 'success') {
            // close modal and reset
            const modalEl = document.getElementById('addEventModal');
            bootstrap.Modal.getInstance(modalEl)?.hide();
            this.reset();
            calendar.refetchEvents();
            showAlert('Event added successfully!', 'success');
          } else {
            // if server returned JSON with message(s), show it
            const msg = (result.data && (result.data.message || JSON.stringify(result.data))) || ('Server error: ' + result.raw);
            showAlert('Failed to add event: ' + msg, 'danger');
          }
        } catch (err) {
          console.error('Add event exception', err);
          showAlert('Network/Exception when adding event. See console for details.', 'danger');
        } finally {
          if (btn) {
            btn.disabled = false;
          }
        }
      });
    }

    // ---------- Edit Event (plain JS) ----------
    const editForm = document.getElementById('editEventForm');
    if (editForm) {
      editForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        if (btn) btn.disabled = true;
        const fd = new FormData(this);
        try {
          const result = await fetchJson('/calendar/update', {
            method: 'POST',
            body: fd
          });
          console.debug('Update result', result);
          if (result.data && result.data.status === 'success') {
            const modalEl = document.getElementById('editEventModal');
            bootstrap.Modal.getInstance(modalEl)?.hide();
            calendar.refetchEvents();
            showAlert('Event updated successfully!', 'success');
          } else {
            const msg = (result.data && (result.data.message || JSON.stringify(result.data))) || ('Server error: ' + result.raw);
            showAlert('Failed to update event: ' + msg, 'danger');
          }
        } catch (err) {
          console.error('Update event exception', err);
          showAlert('Network/Exception when updating event. See console for details.', 'danger');
        } finally {
          if (btn) btn.disabled = false;
        }
      });
    }

    // ---------- Delete Event (plain JS) ----------
    const deleteBtn = document.getElementById('deleteEvent');
    if (deleteBtn) {
      deleteBtn.addEventListener('click', async function() {
        const id = document.getElementById('edit-id').value;
        if (!id) {
          showAlert('No event id selected', 'danger');
          return;
        }
        // find CSRF token field name and value from the edit form
        const editFormEl = document.getElementById('editEventForm');
        const csrfInput = editFormEl.querySelector('input[name^="<?= csrf_token() ?>"], input[name^="__"]') || null;
        // NOTE: If your token name is dynamic, we fallback to reading all inputs that look like CSRF token
        // Build URLSearchParams to include CSRF safely
        const params = new URLSearchParams();
        params.append('id', id);
        // If the page included CSRF <input name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
        // it will also be present in the formData when using FormData. But building URLSearchParams manually:
        try {
          // try to collect CSRF inputs from form
          Array.from(editFormEl.querySelectorAll('input[type="hidden"]')).forEach(i => {
            if (i.name && i.value) params.append(i.name, i.value);
          });
        } catch (err) {
          console.warn('csrf gather err', err);
        }

        try {
          const result = await fetchJson('/calendar/delete', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: params.toString()
          });
          console.debug('Delete result', result);
          if (result.data && result.data.status === 'success') {
            const modalEl = document.getElementById('editEventModal');
            bootstrap.Modal.getInstance(modalEl)?.hide();
            calendar.refetchEvents();
            showAlert('Event deleted successfully!', 'success');
          } else {
            const msg = (result.data && (result.data.message || JSON.stringify(result.data))) || ('Server error: ' + result.raw);
            showAlert('Failed to delete event: ' + msg, 'danger');
          }
        } catch (err) {
          console.error('Delete exception', err);
          showAlert('Network/Exception when deleting event. See console for details.', 'danger');
        }
      });
    }

    // ---------- Helpful dev tip visible on console ----------
    console.info('Calendar script initialized. If add/update still fails: open DevTools → Network and Console. Look for the /calendar/add or /calendar/update request and server response (status + body).');
  });
</script>

<?= $this->endSection() ?>