<?= $this->extend('layouts/base') ?>

<?= $this->section('content') ?>

<div class="fixed-header">
    <?= $this->include('layouts/base-structure/header') ?>
</div>

<style>
body {
    background: #f5f7fb;
}

.marksheet-section {
    margin-top: 110px;
    margin-bottom: 70px;
}

.search-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 40px rgba(0, 0, 0, .08);
}

.card-header-custom {
    background: linear-gradient(135deg, #0d6efd, #2563eb);
    color: #fff;
    padding: 35px;
    text-align: center;
}

.card-header-custom i {
    font-size: 55px;
    margin-bottom: 10px;
}

.card-header-custom h3 {
    margin: 0;
    font-weight: 700;
}

.card-header-custom p {
    margin-top: 8px;
    opacity: .9;
}

.card-body {
    padding: 40px;
}

.section-title {
    font-size: 15px;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: 15px;
}

.btn-group .btn {
    padding: 12px;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.input-group-text {
    background: #f8f9fa;
    width: 55px;
    justify-content: center;
    border-right: none;
}

.form-control,
.form-select {
    height: 54px;
    border-left: none;
    font-size: 15px;
}

.form-control:focus,
.form-select:focus {
    box-shadow: none;
    border-color: #0d6efd;
}

.input-group:focus-within .input-group-text {
    border-color: #0d6efd;
}

.btn-search {
    height: 56px;
    border-radius: 10px;
    font-size: 18px;
    font-weight: 600;
    transition: .3s;
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(13, 110, 253, .25);
}

.search-roll {
    display: none;
}

.form-label {
    font-size: 14px;
    margin-bottom: 6px;
}

.input-group-text {
    width: 45px;
}

.form-control,
.form-select {
    height: 48px;
}

.card-body {
    padding: 30px;
}

@media(min-width:992px) {
    .col-lg-7 {
        max-width: 850px;
    }
}

@media(max-width:768px) {

    .card-body {
        padding: 25px;
    }

    .card-header-custom {
        padding: 25px;
    }

}
</style>

<section class="marksheet-section">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-7">

                <div class="card search-card">

                    <div class="card-header-custom">

                        <i class="bi bi-mortarboard-fill"></i>

                        <h3>Student Marksheet</h3>

                        <p>
                            Search your academic result instantly.
                        </p>

                    </div>

                    <div class="card-body">

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

                            <div class="section-title">
                                Search Method
                            </div>

                            <div class="btn-group w-100 mb-4">

                                <input type="radio" class="btn-check" name="search_type" id="searchById" value="id"
                                    checked>

                                <label class="btn btn-outline-primary" for="searchById">

                                    <i class="bi bi-person-badge"></i>

                                    Student ID

                                </label>

                                <input type="radio" class="btn-check" name="search_type" id="searchByRoll" value="roll">

                                <label class="btn btn-outline-primary" for="searchByRoll">

                                    <i class="bi bi-list-ol"></i>

                                    Class & Roll

                                </label>

                            </div>

                            <div class="search-id">

                                <div class="mb-4">

                                    <label class="form-label">
                                        Student ID
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text">
                                            <i class="bi bi-person-fill"></i>
                                        </span>

                                        <input type="text" class="form-control" name="student_id"
                                            placeholder="Enter Student ID">

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-4">

                                        <label class="form-label">
                                            Examination
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-journal-text"></i>
                                            </span>

                                            <select name="exam" class="form-select">

                                                <option value="">Select Examination</option>

                                                <?php foreach ($exams as $exam): ?>

                                                <option value="<?= esc($exam['exam']) ?>">
                                                    <?= esc($exam['exam']) ?>
                                                </option>

                                                <?php endforeach; ?>

                                            </select>

                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-4">

                                        <label class="form-label">
                                            Academic Year
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text">
                                                <i class="bi bi-calendar-event"></i>
                                            </span>

                                            <select name="year" class="form-select">

                                                <option value="">Select Year</option>

                                                <?php foreach ($years as $year): ?>

                                                <option value="<?= esc($year['year']) ?>">
                                                    <?= esc($year['year']) ?>
                                                </option>

                                                <?php endforeach; ?>

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="search-roll">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Class</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-book"></i></span>
                                            <select name="class" class="form-select">
                                                <option value="">Select Class</option>
                                                <?php foreach ($classes as $class): ?>
                                                <option value="<?= esc($class['class']) ?>"><?= esc($class['class']) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Section</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-people"></i></span>
                                            <select name="section" class="form-select">
                                                <option value="">Select Section</option>
                                                <?php foreach ($sections as $sec): ?>
                                                <option value="<?= esc($sec['section']) ?>">
                                                    <?= ucfirst(esc($sec['section'])) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Roll Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-123"></i></span>
                                            <input type="text" class="form-control" name="roll" placeholder="Roll">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-4">
                                        <label class="form-label">Examination</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-journal-text"></i></span>
                                            <select name="exam" class="form-select">
                                                <option value="">Select Exam</option>
                                                <?php foreach ($exams as $exam): ?>
                                                <option value="<?= esc($exam['exam']) ?>"><?= esc($exam['exam']) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-5">
                                        <label class="form-label">Academic Year</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                                            <select name="year" class="form-select">
                                                <option value="">Select Year</option>
                                                <?php foreach ($years as $year): ?>
                                                <option value="<?= esc($year['year']) ?>"><?= esc($year['year']) ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary btn-search w-100">

                                <i class="bi bi-search me-2"></i>

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