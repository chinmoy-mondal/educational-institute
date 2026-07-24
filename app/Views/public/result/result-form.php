<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<!-- Header -->
<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header') ?>
</div>

<!-- Hero -->
<section class="py-5 bg-light mt-5">
    <div class="container text-center">
        <h2 class="fw-bold text-primary">Student Marksheet</h2>
        <p class="text-muted">
            Search your marksheet using Student ID or Class & Roll.
        </p>
    </div>
</section>

<section class="py-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-7">

                <div class="card shadow border-0">

                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            Search Marksheet
                        </h4>
                    </div>

                    <form action="<?= base_url('show-marksheet') ?>" method="get">

                        <div class="card-body">

                            <?php if (session()->getFlashdata('success')) : ?>
                            <div class="alert alert-success">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                            <?php endif; ?>

                            <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                            <?php endif; ?>

                            <div class="mb-4">

                                <label class="form-label fw-bold">
                                    Search Method
                                </label>

                                <div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="searchById" name="search_type"
                                            value="id" checked>

                                        <label class="form-check-label" for="searchById">
                                            Student ID
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="searchByRoll"
                                            name="search_type" value="roll">

                                        <label class="form-check-label" for="searchByRoll">
                                            Class & Roll
                                        </label>
                                    </div>

                                </div>

                            </div>

                            <div class="search-id mb-3">

                                <label class="form-label">
                                    Student ID
                                </label>

                                <input type="text" name="student_id" class="form-control"
                                    placeholder="Enter Student ID">

                            </div>

                            <div class="search-roll" style="display:none">

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

                                    <input type="text" class="form-control" name="roll" placeholder="Enter Roll">

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">
                                    Exam
                                </label>

                                <select class="form-select" name="exam">

                                    <option value="">
                                        Select Exam
                                    </option>

                                    <?php foreach ($exams as $exam): ?>

                                    <option value="<?= esc($exam['exam']) ?>">
                                        <?= esc($exam['exam']) ?>
                                    </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="mb-3">

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

                        </div>

                        <div class="card-footer text-center">

                            <button class="btn btn-primary btn-lg px-5">

                                Show Marksheet

                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>

<?= $this->include('layouts/base-structure/footer') ?>

<script>
document.addEventListener("DOMContentLoaded", function() {

    const id = document.getElementById("searchById");
    const roll = document.getElementById("searchByRoll");

    const idBox = document.querySelector(".search-id");
    const rollBox = document.querySelector(".search-roll");

    function toggle() {

        if (id.checked) {

            idBox.style.display = "block";
            rollBox.style.display = "none";

        } else {

            idBox.style.display = "block";
            rollBox.style.display = "block";

        }

    }

    id.addEventListener("change", toggle);
    roll.addEventListener("change", toggle);

    toggle();

});
</script>

<?= $this->endSection() ?>