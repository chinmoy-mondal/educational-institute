<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-3">Change Student Photo</h1>
    <a href="<?= site_url('admin/students/view/' . $student['id']) ?>" class="btn btn-secondary mb-3">← Back</a>
  </div>
</div>

<div class="content">
  <div class="container-fluid">

    <?php if (session()->getFlashdata('error')): ?>
      <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('message')): ?>
      <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <div class="card">
	          <div class="card-body text-center">
		          <img src="/<?= esc($student['student_pic']) ?>" class="img-thumbnail mb-3" style="max-width: 200px;">
			          <form method="post" enctype="multipart/form-data" action="<?= site_url('admin/students/edit-photo/' . $student['id']) ?>">
				            <?= csrf_field() ?>
					              <div class="mb-3">
						                  <input type="file" name="student_pic" class="form-control" required accept="image/*">
								            </div>
									              <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Update Photo</button>
										              </form>
											            </div>
												        </div>

  </div>
</div>

<?= $this->endSection() ?>

