<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>
    <!-- Fixed Wrapper for Navbar -->
    <div class="fixed-header">
        <?= $this->include("structure/header"); ?>
    </div>
    
    <div class="container d-flex justify-content-center align-items-center text-center" style="height: 60vh;">
        <div class="alert alert-danger p-4 shadow-lg">
            <h1 class="fw-bold">Sorry! Unable to process your request</h1>
        </div>
    </div>
<?= $this->endSection(); ?>