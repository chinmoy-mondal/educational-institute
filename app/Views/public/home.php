<?= $this->include("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("../layouts/base-structure/header"); ?>
        </div>
        <div class="container content">
            <?= $this->include("../layouts/base-structure/slider"); ?>
        </div>

        <!--  Popular Courses Section -->
        <div class="popular-courses py-5">
            <div class="container">
                <?= $this->include("../layouts/base-structure/section1"); ?>
            </div>
            <div class="container">
                <?= $this->include("../layouts/base-structure/section2"); ?>
            </div>
        </div>

        <?= $this->include("../layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>
  
