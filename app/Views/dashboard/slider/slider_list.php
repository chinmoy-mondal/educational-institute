<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-images"></i> Slider List
                </h3>
                <div>
                    <a href="<?= base_url('admin/sliderForm') ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-plus-circle"></i> Add Slider
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table id="sliderTable" class="table table-bordered table-hover table-striped text-center">
                        <thead class="bg-navy">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Caption</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($sliders)): ?>
                            <?php $i = 1;
                                foreach ($sliders as $slider): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($slider['title']) ?></td>
                                <td><?= esc($slider['caption']) ?></td>
                                <td>
                                    <?php if (!empty($slider['image'])): ?>
                                    <img src="<?= base_url('uploads/sliders/' . $slider['image']) ?>" alt="Slider"
                                        width="100" class="img-thumbnail">
                                    <?php else: ?>
                                    <span class="text-muted">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $slider['status'] ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>' ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/editSlider/' . $slider['id']) ?>"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= base_url('admin/deleteSlider/' . $slider['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this slider?')"
                                        class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No sliders found.</td>
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