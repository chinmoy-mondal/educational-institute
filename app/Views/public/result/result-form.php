<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header') ?>
</div>

<style>
.hero-section {
    margin-top: 80px;
    background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    color: #fff;
    padding: 80px 0;
}

.search-card {
    border: none;
    border-radius: 18px;
    box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
}

.search-card .card-body {
    padding: 40px;
}

.form-control,
.form-select {
    height: 52px;
    border-radius: 10px;
}

.form-control:focus,
.form-select:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

.form-check {
    margin-right: 20px;
}

.btn-search {
    height: 55px;
    font-size: 18px;
    border-radius: 10px;
}

.section-title {
    font-weight: 700;
    margin-bottom: 5px;
}

.section-subtitle {
    color: #6c757d;
}

.logo-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
}

.logo-circle img {
    width: 65px;
}

@media(max-width:768px) {

    .hero-section {
        padding: 60px 0;
    }

    .search-card .card-body {
        padding: 25px;
    }

}
</style>

<!-- Hero -->
<section class="hero-section">

    <div class="container text-center">

        <h1 class="fw-bold">
            Student Marksheet Portal
        </h1>

        <p class="lead mb-0">
            Search and view your academic marksheet online.
        </p>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card search-card">

                    <div class="card-body">

                        <div class="logo-circle mb-4">

                            <img src="<?= base_url('public/assets/img/logo.jpg') ?>">

                        </div>

                        <h3 class="text-center section-title">
                            Search Marksheet
                        </h3>

                        <p class="text-center section-subtitle mb-4">
                            Search by Student ID or by Class & Roll.
                        </p>

                        <?php if (session()->getFlashdata('success')): ?>

                        <div class="alert alert-success">

                            <?= session()->getFlashdata('success') ?>

                        </div>

                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>

                        <div class="alert alert-danger">

                            <?= session()->getFlashdata('error') ?>

                        </div>

                        <?php endif; ?>

                        <form action="<?= base_url('show-marksheet') ?>" method="get">

                            <div class="mb-4">

                                <label class="fw-bold mb-2">
                                    Search Method
                                </label>

                                <div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" type="radio" name="search_type" id="searchById"
                                            value="id" checked>

                                        <label class="form-check-label" for="searchById">

                                            Student ID

                                        </label>

                                    </div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" type="radio" name="search_type"
                                            id="searchByRoll" value="roll">

                                        <label class="form-check-label" for="searchByRoll">

                                            Class & Roll

                                        </label>

                                    </div>

                                </div>

                            </div>

                            <!-- Student ID -->

                            <div class="search-id">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Student ID

                                    </label>

                                    <input type="text" name="student_id" class="form-control"
                                        placeholder="Enter Student ID">

                                </div>

                            </div>

                            <!-- Class Roll -->

                            <div class="search-roll" style="display:none;">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Class

                                    </label>

                                    <select name="class" class="form-select">

                                        <option value="">
                                            Select Class
                                        </option>

                                        <?php foreach ($classes as $class): ?>

                                        <option value="<?= esc($class['class']) ?>">

                                            <?= esc($class['class']) ?>

                                        </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">

                                        Section

                                    </label>

                                    <select name="section" class="form-select">

                                        <option value="">
                                            Select Section
                                        </option>

                                        <?php foreach ($sections as $sec): ?>

                                        <option value="<?= esc($sec['section']) ?>">

                                            <?= ucfirst(esc($sec['section'])) ?>

                                        </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">

                                        Roll

                                    </label>

                                    <input type="text" class="form-control" name="roll" placeholder="Enter Roll Number">

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">

                                    Examination

                                </label>

                                <select class="form-select" name="exam">

                                    <option value="">
                                        Select Examination
                                    </option>

                                    <?php foreach ($exams as $exam): ?>

                                    <option value="<?= esc($exam['exam']) ?>">

                                        <?= esc($exam['exam']) ?>

                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="mb-4">

                                <label class="form-label">

                                    Year

                                </label>

                                <select class="form-select" name="year">

                                    <option value="">
                                        Select Year
                                    </option>

                                    <?php foreach ($years as $year): ?>

                                    <option value="<?= esc($year['year']) ?>">

                                        <?= esc($year['year']) ?>

                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <button class="btn btn-primary btn-search w-100">

                                Show Marksheet

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<?= $this->include('layouts/base-structure/footer') ?>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const idRadio = document.getElementById("searchById");
    const rollRadio = document.getElementById("searchByRoll");

    const idBox = document.querySelector(".search-id");
    const rollBox = document.querySelector(".search-roll");

    function toggleFields() {

        if (idRadio.checked) {

            idBox.style.display = "block";
            rollBox.style.display = "none";

        } else {

            idBox.style.display = "none";
            rollBox.style.display = "block";

        }

    }

    idRadio.addEventListener("change", toggleFields);
    rollRadio.addEventListener("change", toggleFields);

    toggleFields();

});
</script>

<?= $this->endSection() ?>