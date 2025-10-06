<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <!-- Page Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-bullhorn"></i> Add Notice</h1>
        </div>
        <div class="col-sm-6 text-right">
          <a href="<?= base_url('dashboard/notices') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to List
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card card-primary shadow-sm">
            <div class="card-header">
              <h3 class="card-title"><i class="fas fa-edit"></i> Create New Notice</h3>
            </div>

            <!-- form start -->
            <form action="<?= base_url('dashboard/saveNotice') ?>" method="post" enctype="multipart/form-data">
              <?= csrf_field() ?>

              <div class="card-body">
                <div class="form-group">
                  <label for="title">Notice Title <span class="text-danger">*</span></label>
                  <input type="text" name="title" id="title" class="form-control" placeholder="Enter notice title" required>
                </div>

                <div class="form-group">
                  <label for="description">Notice Description <span class="text-danger">*</span></label>
                  <textarea name="description" id="description" class="form-control" rows="5" placeholder="Write full notice here..." required></textarea>
                </div>

                <div class="form-group">
                  <label for="notice_date">Notice Date <span class="text-danger">*</span></label>
                  <input type="date" name="notice_date" id="notice_date" class="form-control" required>
                </div>

                <div class="form-group">
                  <label for="attachment">Attach File (optional)</label>
                  <input type="file" name="attachment" id="attachment" class="form-control">
                  <small class="form-text text-muted">Supported formats: PDF, JPG, PNG, DOCX</small>
                </div>

                <div class="form-group">
                  <label for="status">Status</label>
                  <select name="status" id="status" class="form-control">
                    <option value="1">Active (Show Publicly)</option>
                    <option value="0">Inactive (Hidden)</option>
                  </select>
                </div>
              </div>

              <div class="card-footer text-center">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Notice</button>
                <button type="reset" class="btn btn-warning"><i class="fas fa-undo"></i> Reset</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>