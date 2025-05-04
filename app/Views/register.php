<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

<!-- Fixed Wrapper for Navbar -->
<div class="fixed-header">
    <?= $this->include("structure/header"); ?>
</div>

<!-- Registration Form -->
<div class="container content mb-5 pb-5"> 
    <div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">
        Register
    </div>
</div>

<!-- Footer Include -->
<?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>