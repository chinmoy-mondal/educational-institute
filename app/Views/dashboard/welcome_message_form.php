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

                        <form action="<?= base_url('admin/welcome-message/save') ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <div class="card-body">

                                <!-- Title -->
                                <div class="form-group">
                                    <label>Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control"
                                        value="<?= !empty($welcome['title']) ? $welcome['title'] : '' ?>" required>
                                </div>

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

                                <!-- Rich Text Message -->
                                <div class="form-group">
                                    <label>Message <span class="text-danger">*</span></label>
                                    <textarea id="editor" name="message" class="form-control" rows="10">
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

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#editor',
        height: 400,
        plugins: [
            'advlist autolink lists link image charmap print preview anchor',
            'searchreplace visualblocks code fullscreen',
            'insertdatetime media table paste help wordcount',
            'codesample emoticons'
        ],
        toolbar: 'undo redo | formatselect | ' +
            'bold italic underline strikethrough forecolor backcolor | ' +
            'alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | ' +
            'link image media table codesample emoticons | ' +
            'removeformat | fullscreen preview code',
        menubar: 'file edit view insert format tools table help',
        content_style: 'body { font-family:Arial,sans-serif; font-size:14px }'
    });
</script>