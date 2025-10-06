<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-edit"></i> Edit Notice</h1>
        </div>
        <div class="col-sm-6 text-right">
          <a href="<?= base_url('dashboard/notices') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-primary shadow-sm">
            <div class="card-header">
              <h3 class="card-title">Update Notice</h3>
            </div>

            <form action="<?= base_url('dashboard/updateNotice/' . $notice['id']) ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="card-body">
                <div class="form-group">
                  <label>Notice Title</label>
                  <input type="text" name="title" class="form-control" value="<?= esc($notice['title']) ?>" required>
                </div>

                <div class="form-group">
                  <label>Notice Description</label>
                  <textarea name="description" class="form-control" rows="5" required><?= esc($notice['description']) ?></textarea>
                </div>

                <div class="form-group">
                  <label>Notice Date</label>
                  <input type="date" name="notice_date" class="form-control" value="<?= esc($notice['notice_date']) ?>" required>
                </div>

                <div class="form-group">
                  <label>Attachment</label><br>
                  <?php if (!empty($notice['attachment'])): ?>
                    <a href="<?= base_url('uploads/notices/' . $notice['attachment']) ?>" target="_blank">
                      <i class="fas fa-file"></i> View Current File
                    </a><br><br>
                  <?php endif; ?>
                  <input type="file" name="attachment" class="form-control">
                </div>

                <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="1" <?= $notice['status'] == 1 ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= $notice['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                  </select>
                </div>
              </div>

              <div class="card-footer text-center">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>