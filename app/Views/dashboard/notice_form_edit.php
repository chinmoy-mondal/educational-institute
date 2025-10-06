<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
// Ensure $notice is always defined (safe for both Add & Edit)
$notice = $notice ?? [
  'id' => '',
  'title' => '',
  'body' => '',
  'notice_date' => '',
  'document_url' => '',
  'status' => 1
];

// Determine form mode
$isEdit = !empty($notice['id']);
$formAction = $isEdit
  ? base_url('admin/updateNotice/' . $notice['id'])
  : base_url('admin/saveNotice');
?>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>
          <i class="fas fa-bullhorn"></i>
          <?= $isEdit ? 'Edit Notice' : 'Add New Notice' ?>
        </h1>
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
            <h3 class="card-title"><?= $isEdit ? 'Update Notice Information' : 'Create New Notice' ?></h3>
          </div>

          <form action="<?= $formAction ?>" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="card-body">

              <!-- Notice Title -->
              <div class="form-group">
                <label><i class="fas fa-heading"></i> Notice Title</label>
                <input type="text" name="title" class="form-control" 
                       value="<?= esc($notice['title']) ?>" required>
              </div>

              <!-- Notice Body -->
              <div class="form-group">
                <label><i class="fas fa-align-left"></i> Notice Body</label>
                <textarea name="body" class="form-control" rows="5" required><?= esc($notice['body']) ?></textarea>
              </div>

              <!-- Notice Date -->
              <div class="form-group">
                <label><i class="fas fa-calendar-alt"></i> Notice Date</label>
                <input type="date" name="notice_date" class="form-control"
                       value="<?= esc($notice['notice_date']) ?>" required>
              </div>

              <!-- File Attachment -->
              <div class="form-group">
                <label><i class="fas fa-paperclip"></i> Attachment (optional)</label><br>
                <?php if (!empty($notice['document_url'])): ?>
                  <a href="<?= base_url('uploads/notices/' . $notice['document_url']) ?>" 
                     target="_blank" class="d-block mb-2">
                    <i class="fas fa-file"></i> View Current File
                  </a>
                <?php endif; ?>
                <input type="file" name="document_url" class="form-control">
              </div>

              <!-- Status -->
              <div class="form-group">
                <label><i class="fas fa-toggle-on"></i> Status</label>
                <select name="status" class="form-control">
                  <option value="1" <?= ($notice['status'] == 1) ? 'selected' : '' ?>>Active</option>
                  <option value="0" <?= ($notice['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
              </div>
            </div>

            <!-- Buttons -->
            <div class="card-footer text-center">
              <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> <?= $isEdit ? 'Update Notice' : 'Save Notice' ?>
              </button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>