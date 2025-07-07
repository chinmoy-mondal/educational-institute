<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("structure/header"); ?>
        </div>
        <div class="container content">
            <?= $this->include("structure/slider"); ?>
        </div>

        <!--  Popular Courses Section -->
        <div class="popular-courses py-5">
            <div class="container">
                <?= $this->include("structure/section1"); ?>
            </div>
            <div class="container">
                <?= $this->include("structure/section2"); ?>
            </div>
        </div>

        <?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>
  