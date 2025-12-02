<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-wrapper">

    <!-- Page Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-handshake"></i> Welcome Message</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
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
                            <h3 class="card-title">
                                <i class="fas fa-edit"></i> Edit Welcome Message
                            </h3>
                        </div>

                        <!-- form start -->
                        <form action="<?= base_url('admin/welcome-message/save') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="card-body">

                                <!-- Existing Photo -->
                                <div class="form-group">
                                    <label>Photo</label><br>

                                    <?php if (!empty($welcome['photo'])): ?>
                                        <img src="<?= base_url('uploads/welcome/' . $welcome['photo']); ?>"
                                            width="150" class="rounded mb-2 shadow">
                                    <?php endif; ?>

                                    <input type="file" name="photo" class="form-control">
                                    <small class="text-muted">Upload JPG or PNG photo of Principal/Head</small>
                                </div>

                                <!-- Welcome Message -->
                                <div class="form-group">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea id="summernote" name="message" class="form-control" rows="6" required>
                    <?= !empty($welcome['message']) ? $welcome['message'] : '' ?>
                  </textarea>
                                </div>

                            </div>

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Message
                                </button>
                                <button type="reset" class="btn btn-warning">
                                    <i class="fas fa-undo"></i> Reset
                                </button>
                            </div>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection() ?>

<!-- Summernote -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script>
    $(function() {
        $('#summernote').summernote({
            height: 250,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['font2', ['fontsize', 'color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });
    });
</script>