<?= $this->extend('layouts/admin') ?>
<?= $this->section("content") ?>

<section class="content">
    <div class="container-fluid">
        <div class="card card-primary card-outline shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-handshake"></i> Welcome Message List
                </h3>
                <div>
                    <a href="<?= base_url('admin/welcomeMessageForm') ?>" class="btn btn-sm btn-success">
                        <i class="fas fa-plus-circle"></i> Add Welcome Message
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
                <!-- End Flash Messages -->

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead class="bg-navy text-center">
                            <tr>
                                <th width="5%">#</th>
                                <th>Photo</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($welcomeMessages)): ?>
                            <?php $i = 1;
                                foreach ($welcomeMessages as $message): ?>
                            <tr>
                                <td class="text-center"><?= $i++ ?></td>

                                <!-- Photo -->
                                <td class="text-center">
                                    <?php if (!empty($message['photo'])): ?>
                                    <img src="<?= base_url('uploads/welcome/' . $message['photo']) ?>" width="60"
                                        height="60" style="object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                    <span class="text-muted">No Photo</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Title -->
                                <td><?= esc($message['title']) ?></td>

                                <!-- Short Message Preview -->
                                <td>
                                    <?= esc(substr($message['message'], 0, 100)) ?>...
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    <?= $message['status']
                                                ? '<span class="badge bg-success">Active</span>'
                                                : '<span class="badge bg-secondary">Inactive</span>' ?>
                                </td>

                                <!-- Actions -->
                                <td class="text-center">
                                    <a href="<?= base_url('admin/editWelcomeMessage/' . $message['id']) ?>"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="<?= base_url('admin/deleteWelcomeMessage/' . $message['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this message?')"
                                        class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No welcome messages found.</td>
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