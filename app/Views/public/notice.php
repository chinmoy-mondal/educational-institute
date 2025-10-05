<?= $this->extend('layouts/base.php') ?>
<?= $this->section('content') ?>

<div class="container py-5">

  <h2 class="mb-4 fw-bold text-center text-primary">School Notices</h2>

  <!-- ───────────── Search / Filter ───────────── -->
  <form method="get" class="row g-2 mb-4 justify-content-center">
      <div class="col-md-4">
          <input type="text" name="keyword" class="form-control" value="<?= esc($keyword ?? '') ?>" placeholder="Search notice title or description">
      </div>
      <div class="col-md-2 d-grid">
          <button class="btn btn-primary">Search</button>
      </div>
  </form>

  <!-- ───────────── Notices List ───────────── -->
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
      <?php if (!empty($notices)): ?>
        <?php foreach ($notices as $i => $n): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td class="text-start">
              <strong><?= esc($n['title']) ?></strong><br>
              <small class="text-muted"><?= esc($n['description']) ?></small>
          </td>
          <td><?= date('d M Y', strtotime($n['date'])) ?></td>
          <td>
            <?php if (!empty($n['file'])): ?>
              <a href="<?= base_url('uploads/notices/' . $n['file']) ?>" target="_blank" class="btn btn-sm btn-success">
                <i class="bi bi-file-earmark-arrow-down"></i> View
              </a>
            <?php else: ?>
              <span class="text-muted">No file</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4">No notices found</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- ───────────── Pagination ───────────── -->
  <div class="d-flex justify-content-center mt-3">
      <?= $pager->links() ?>
  </div>

</div>

<?= $this->endSection() ?>