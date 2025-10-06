<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0">
          <i class="fas fa-bullhorn"></i> Notice List
        </h3>
        <div>
          <a href="<?= base_url('dashboard/noticeForm') ?>" class="btn btn-sm btn-success">
            <i class="fas fa-plus-circle"></i> Add Notice
          </a>
        </div>
      </div>

      <div class="card-body">
        <!-- Flash Messages -->
        <?php if (session()->getFlashdata('success')): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>
        <!-- End Flash Messages -->

        <div class="table-responsive">
          <table id="noticeTable" class="table table-bordered table-hover table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th width="5%">#</th>
                <th>Title</th>
                <th>Notice Body</th>
                <th>Date</th>
                <th>Document</th>
                <th width="15%">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($notices)): ?>
                <?php $i = 1; foreach ($notices as $notice): ?>
                  <tr>
                    <td class="text-center"><?= $i++ ?></td>
                    <td><?= esc($notice['title']) ?></td>
                    <td><?= esc($notice['body']) ?></td>
                    <td class="text-center"><?= date('d M, Y', strtotime($notice['notice_date'])) ?></td>
                    <td class="text-center">
                      <?php if (!empty($notice['document_url'])): ?>
                        <a href="<?= base_url('uploads/notices/' . $notice['document_url']) ?>" target="_blank" class="btn btn-sm btn-info">
                          <i class="fas fa-file"></i> View
                        </a>
                      <?php else: ?>
                        <span class="text-muted">No File</span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center">
                      <a href="<?= base_url('dashboard/editNotice/' . $notice['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('dashboard/deleteNotice/' . $notice['id']) ?>"
                        onclick="return confirm('Are you sure you want to delete this notice?')"
                        class="btn btn-sm btn-danger" title="Delete">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">No notices found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>