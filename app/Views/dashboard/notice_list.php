<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">
  <!-- Header -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-bullhorn"></i> Notice Board</h1>
        </div>
        <div class="col-sm-6 text-right">
          <a href="<?= base_url('dashboard/noticeForm') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Add New Notice
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h3 class="card-title"><i class="fas fa-list"></i> All Notices</h3>
        </div>

        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
              <tr class="text-center">
                <th width="5%">#</th>
                <th>Title</th>
                <th>Description</th>
                <th>Date</th>
                <th>Attachment</th>
                <th>Status</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($notices)): ?>
                <?php $i = 1; foreach ($notices as $notice): ?>
                  <tr class="text-center">
                    <td><?= $i++ ?></td>
                    <td><?= esc($notice['title']) ?></td>
                    <td><?= esc(word_limiter($notice['description'], 10)) ?></td>
                    <td><?= date('d M, Y', strtotime($notice['notice_date'])) ?></td>
                    <td>
                      <?php if (!empty($notice['attachment'])): ?>
                        <a href="<?= base_url('uploads/notices/' . $notice['attachment']) ?>" target="_blank" class="btn btn-info btn-sm">
                          <i class="fas fa-file"></i> View
                        </a>
                      <?php else: ?>
                        <span class="badge badge-secondary">No File</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <?php if ($notice['status'] == 1): ?>
                        <span class="badge badge-success">Active</span>
                      <?php else: ?>
                        <span class="badge badge-danger">Inactive</span>
                      <?php endif; ?>
                    </td>
                    <td>
                      <a href="<?= base_url('dashboard/editNotice/' . $notice['id']) ?>" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('dashboard/deleteNotice/' . $notice['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this notice?')">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">No notices found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>

<?= $this->endSection() ?>