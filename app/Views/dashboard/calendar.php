<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Event Calendar</h5>
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addEventModal">
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

<!-- ================= ADD EVENT MODAL ================= -->
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

                    <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>

                    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>

                    <select name="category" id="add-category" class="form-control mb-2">
                        <option value="">Select Category</option>
                        <option value="Exam">Exam</option>
                        <option value="Notice">Notice</option>
                        <option value="Holiday">Holiday</option>
                        <option value="Vacation">Vacation</option>
                    </select>

                    <select name="subcategory" id="add-subcategory" class="form-control mb-2"></select>

                    <select name="class" id="add-class" class="form-control mb-2">
                        <option value="">Select Class</option>
                        <option value="6">Class 6</option>
                        <option value="7">Class 7</option>
                        <option value="8">Class 8</option>
                        <option value="9">Class 9</option>
                        <option value="10">Class 10</option>
                    </select>

                    <select name="subject" class="form-control mb-2">
                        <option value="">Select Subject</option>
                        <?php foreach ($subjects as $subject): ?>
                        <option value="<?= esc($subject['id']) ?>">
                            <?= esc($subject['class']) ?> - <?= esc($subject['subject']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>

                    <input type="date" name="start_date" class="form-control mb-2" required>
                    <input type="time" name="start_time" class="form-control mb-2" required>

                    <input type="date" name="end_date" class="form-control mb-2" required>
                    <input type="time" name="end_time" class="form-control mb-2" required>

                    <input type="color" name="color" class="form-control mb-2" value="#007bff">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editEventModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editEventForm">

                <input type="hidden" id="edit-id" name="id">

                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="text" id="edit-title" name="title" class="form-control mb-2">

                    <textarea id="edit-description" name="description" class="form-control mb-2"></textarea>

                    <select id="edit-category" name="category" class="form-control mb-2"></select>

                    <select id="edit-subcategory" name="subcategory" class="form-control mb-2"></select>

                    <select id="edit-class" name="class" class="form-control mb-2"></select>

                    <select id="edit-subject" name="subject" class="form-control mb-2"></select>

                    <input type="date" id="edit-start-date" name="start_date" class="form-control mb-2">
                    <input type="time" id="edit-start-time" name="start_time" class="form-control mb-2">

                    <input type="date" id="edit-end-date" name="end_date" class="form-control mb-2">
                    <input type="time" id="edit-end-time" name="end_time" class="form-control mb-2">

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- ================= FULLCALENDAR ================= -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    const calendarEl = document.getElementById('calendar');

    const calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'dayGridMonth',
        height: 650,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek'
        },

        // ✅ IMPORTANT FIX (your route)
        events: '<?= base_url('admin/public-calendar/events') ?>',

        eventDidMount: function(info) {
            info.el.style.backgroundColor = info.event.backgroundColor || '#0d6efd';
            info.el.style.color = '#fff';
            info.el.style.borderRadius = '6px';
            info.el.style.padding = '3px';
        },

        eventClick: function(info) {

            const e = info.event;

            document.getElementById('edit-id').value = e.id;
            document.getElementById('edit-title').value = e.title || '';
            document.getElementById('edit-description').value = e.extendedProps.description || '';

            document.getElementById('edit-category').value = e.extendedProps.category || '';
            document.getElementById('edit-subcategory').value = e.extendedProps.subcategory || '';
            document.getElementById('edit-class').value = e.extendedProps.event_class || '';
            document.getElementById('edit-subject').value = e.extendedProps.subject || '';

            if (e.start) {
                let s = new Date(e.start);
                document.getElementById('edit-start-date').value = s.toISOString().slice(0, 10);
                document.getElementById('edit-start-time').value = s.toTimeString().slice(0, 5);
            }

            if (e.end) {
                let en = new Date(e.end);
                document.getElementById('edit-end-date').value = en.toISOString().slice(0, 10);
                document.getElementById('edit-end-time').value = en.toTimeString().slice(0, 5);
            }

            new bootstrap.Modal(document.getElementById('editEventModal')).show();
        }
    });

    calendar.render();

});
</script>

<?= $this->endSection() ?>