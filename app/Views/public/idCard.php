<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<div class="container py-5">
  <h4 class="text-center mb-4"><?= esc($student['school_name']) ?> – Student ID Card</h4>

  <div class="d-flex flex-wrap justify-content-center gap-4">

    <!-- FRONT SIDE -->
    <div id="card-front" class="id-card" style="background-image: url('<?= base_url("public/uploads/bg-front.png") ?>');">
      <!-- Logo -->
      <div class="text-center mb-2">
        <?php if ($student['logo']): ?>
          <img src="<?= $student['logo'] ?>" height="90" alt="Logo" />
        <?php endif; ?>
      </div>

      <h6 class="text-white text-center fw-bold mb-0"><?= esc($student['eiin']) ?></h6>
      <h6 class="text-white text-center fw-bold mb-0"><?= esc($student['school_name']) ?></h6>
      <br>

      <!-- Student photo -->
      <div class="d-flex justify-content-center mb-3">
        <img src="<?= base_url('public/uploads/' . $student['student_pic']) ?>" alt="Photo" class="photo" />
      </div>

      <!-- Info -->
      <div class="text-center text-black mb-1">
        <h4 class="mb-1 fw-bold"><?= esc($student['student_name']) ?></h4>
        <p class="mb-0 fw-semibold">STUDENT</p>
        <p class="mb-0 fw-semibold">ID NO: <?= esc($student['roll']) ?></p>
        <p class="mb-0">Blood Group: <?= esc($student['blood']) ?></p>
        <p class="mb-0">Phone: <?= esc($student['phone']) ?></p>
      </div>

      <!-- Signature -->
      <div class="d-flex justify-content-end align-items-end mt-auto">
        <div class="text-end">
          <?php if ($student['signature']): ?>
            <img src="<?= $student['signature'] ?>" alt="Signature" class="signature mb-1" />
          <?php endif; ?>
          <div class="small text-muted">Authorized Signature</div>
        </div>
      </div>
    </div>

    <!-- BACK SIDE (similar, using $student['id'], etc.) -->
    <!-- ... -->

  </div>
</div>

<?= $this->endSection(); ?>
