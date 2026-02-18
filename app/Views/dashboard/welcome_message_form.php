<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline shadow">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-handshake"></i> <?= isset($welcome) ? 'Edit' : 'Add' ?> Welcome Message
                </h3>
            </div>

            <form action="<?= base_url('admin/saveWelcomeMessage') ?>" method="post" enctype="multipart/form-data">
                <div class="card-body">

                    <?php if (isset($welcome)): ?>
                    <input type="hidden" name="id" value="<?= $welcome['id'] ?>">
                    <?php endif; ?>

                    <!-- Title -->
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" value="<?= $welcome['title'] ?? '' ?>"
                            required>
                    </div>

                    <!-- Photo -->
                    <div class="form-group mt-3">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control">

                        <?php if (!empty($welcome['photo'])): ?>
                        <div class="mt-2">
                            <img src="<?= base_url('uploads/welcome/' . $welcome['photo']) ?>" width="100"
                                style="border-radius:5px;">
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Message -->
                    <div class="form-group mt-3">
                        <label>Message</label>
                        <textarea name="message" rows="5" class="form-control"
                            required><?= $welcome['message'] ?? '' ?></textarea>
                    </div>

                    <!-- Status -->
                    <div class="form-group mt-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="1" <?= (isset($welcome) && $welcome['status'] == 1) ? 'selected' : '' ?>>
                                Active</option>
                            <option value="0" <?= (isset($welcome) && $welcome['status'] == 0) ? 'selected' : '' ?>>
                                Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
                    <a href="<?= base_url('admin/welcomeMessages') ?>" class="btn btn-secondary">Back</a>
                </div>
            </form>

        </div>
    </div>
</section>

<?= $this->endSection() ?>