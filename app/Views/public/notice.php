<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="container py-5">

  <h2 class="mb-4 fw-bold text-center text-primary">School Notices</h2>

  <!-- ───────────── search / filter form (static visual only) ───────────── -->
  <form method="get" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-3">
          <input type="text" name="keyword" class="form-control" placeholder="Search notice (static)">
      </div>
      <div class="col-md-2 d-grid">
          <button type="button" class="btn btn-primary">Search</button>
      </div>
  </form>

  <!-- ───────────── notice table ───────────── -->
  <div class="table-responsive">
    <table class="table table-bordered align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th width="10%">#</th>
          <th width="40%">Title</th>
          <th width="30%">Date</th>
          <th width="20%">Download / View</th>
        </tr>
      </thead>
      <tbody>

        <tr>
          <td>1</td>
          <td class="text-start">
            <strong>Mid-Term Examination Routine 2025</strong><br>
            <small class="text-muted">
              The mid-term examination will start from 10th October 2025.
              Students are advised to collect their admit cards from the office.
            </small>
          </td>
          <td>01 Oct 2025</td>
          <td>
            <a href="<?= base_url('uploads/notices/exam_routine.pdf') ?>" target="_blank" class="btn btn-sm btn-success">
              <i class="bi bi-file-earmark-arrow-down"></i> View
            </a>
          </td>
        </tr>

        <tr>
          <td>2</td>
          <td class="text-start">
            <strong>Holiday Notice</strong><br>
            <small class="text-muted">
              The school will remain closed on 12th October 2025 (Sunday)
              due to a national event.
            </small>
          </td>
          <td>03 Oct 2025</td>
          <td><span class="text-muted">No file</span></td>
        </tr>

        <tr>
          <td>3</td>
          <td class="text-start">
            <strong>Science Fair 2025</strong><br>
            <small class="text-muted">
              All science group students are requested to submit their project names by 8th October.
              The fair will be held on 15th October 2025.
            </small>
          </td>
          <td>28 Sep 2025</td>
          <td>
            <a href="<?= base_url('uploads/notices/science_fair.pdf') ?>" target="_blank" class="btn btn-sm btn-success">
              <i class="bi bi-file-earmark-arrow-down"></i> View
            </a>
          </td>
        </tr>

        <tr>
          <td>4</td>
          <td class="text-start">
            <strong>Parent-Teacher Meeting</strong><br>
            <small class="text-muted">
              A parent-teacher meeting for all classes will be held on 20th October 2025 at 10:00 AM in the school auditorium.
            </small>
          </td>
          <td>05 Oct 2025</td>
          <td><span class="text-muted">No file</span></td>
        </tr>

        <tr>
          <td>5</td>
          <td class="text-start">
            <strong>Admission Notice (Session 2026)</strong><br>
            <small class="text-muted">
              Admission forms for the academic session 2026 will be available from 1st November 2025.
              Last date for submission is 15th November 2025.
            </small>
          </td>
          <td>05 Oct 2025</td>
          <td>
            <a href="<?= base_url('uploads/notices/admission_2026.pdf') ?>" target="_blank" class="btn btn-sm btn-success">
              <i class="bi bi-file-earmark-arrow-down"></i> View
            </a>
          </td>
        </tr>

      </tbody>
    </table>
  </div>

</div>

<?= $this->endSection() ?>