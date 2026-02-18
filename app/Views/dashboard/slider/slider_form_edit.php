<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline shadow">
            <div class="card-header">
                <h3 class="card-title mb-0">
                    <i class="fas fa-images"></i> <?= $title ?>
                </h3>
            </div>

            <div class="card-body">
                <!-- Update form -->
                <form action="<?= base_url('admin/updateSlider/' . $slider['id']) ?>" method="post"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control"
                            value="<?= esc($slider['title']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="caption" class="form-label">Caption</label>
                        <textarea name="caption" id="caption" class="form-control"
                            rows="3"><?= esc($slider['caption']) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        <?php if (!empty($slider['image'])): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('uploads/sliders/' . $slider['image']) ?>" width="150"
                                class="img-thumbnail">
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" name="status" id="status" value="1"
                            <?= ($slider['status'] == 1) ? 'checked' : '' ?>>
                        <label for="status" class="form-check-label">Active</label>
                    </div>

                    <input type="hidden" name="id" value="<?= $slider['id'] ?>">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Slider
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>