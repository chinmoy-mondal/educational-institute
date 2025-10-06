<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content") ?>

<!-- Fixed Header -->
<div class="fixed-header">
  <?= $this->include("layouts/base-structure/header") ?>
</div>

<!-- Page Title -->
<div class="page-title text-center py-5 bg-light">
  <div class="container">
    <h2 class="fw-bold text-primary">School Notices</h2>
    <p class="text-muted mb-0">Stay updated with our latest announcements</p>
  </div>
</div>

<!-- Notice Table Section -->
<section class="py-5">
  <div class="container">

    <!-- Search / Filter Form (optional) -->
    <form method="get" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-3">
        <input type="text" name="keyword" class="form-control" placeholder="Search notice">
      </div>
      <div class="col-md-2 d-grid">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </form>

    <!-- Notice Table -->
    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center shadow-sm">
        <thead class="table-dark">
          <tr>
            <th width="10%">#</th>
            <th width="40%">Title</th>
            <th width="30%">Date</th>
            <th width="20%">Download / View</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($notices)): ?>
            <?php $i = 1; foreach ($notices as $notice): ?>
              <tr>
                <td><?= $i++ ?></td>
                <td class="text-start">
                  <strong><?= esc($notice['title']) ?></strong><br>
                  <small class="text-muted"><?= esc($notice['body']) ?></small>
                </td>
                <td><?= date('d M, Y', strtotime($notice['notice_date'])) ?></td>
                <td>
                  <?php if (!empty($notice['document_url'])): ?>
                    <a href="<?= base_url('uploads/notices/' . $notice['document_url']) ?>" target="_blank" class="btn btn-sm btn-success">
                      <i class="bi bi-file-earmark-arrow-down"></i> View
                    </a>
                  <?php else: ?>
                    <span class="text-muted">No file</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center text-muted">No notices found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Footer -->
<?= $this->include("layouts/base-structure/footer") ?>

<?= $this->endSection() ?>