<?= $this->extend("layouts/base.php") ?>
<?= $this->section("content"); ?>

<style>
  body {
    background: #f2f4f8;
    font-family: Arial, sans-serif;
  }
  .id-card {
    width: 350px;
    height: 550px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 0 12px rgba(0,0,0,0.15);
    background-size: cover;
    background-position: center;
    position: relative;
    padding: 20px;
    display: flex;
    flex-direction: column;
  }
  .photo {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 6px solid #ffffff;
    border-radius: 50%;
  }
  .qr-img {
    width: 100px;
    height: 100px;
    border: 1px solid #ccc;
    background: #fff;
    padding: 4px;
    border-radius: 6px;
  }
  .signature {
    width: 100px;
  }
</style>

<div class="container py-5">
  <h4 class="text-center mb-4"><?= esc($student['school_name']) ?> – Student ID Card</h4>

  <div class="d-flex flex-wrap justify-content-center gap-4">

    <!-- FRONT -->
    <div id="card-front" class="id-card" style="background-image: url('<?= base_url("public/assets/img/bg-front.png") ?>');">
      <!-- Logo -->
      <div class="text-center mb-2">
        <img src="<?= esc($student['logo']) ?>" height="90" alt="Logo" />
      </div>

      <!-- School name -->
      <h6 class="text-white text-center fw-bold mb-0"><?= esc($student['eiin']) ?></h6>
      <h6 class="text-white text-center fw-bold mb-0"><?= esc($student['school_name']) ?></h6>
      <br>

      <!-- Photo -->
      <div class="d-flex justify-content-center mb-3">
	      <?php if (!empty($student['student_pic'])): ?>
		<img src="/<?= esc($student['student_pic']) ?>" alt="Photo" class="photo" crossorigin="anonymous">
	      <?php else: ?>
		<img src="<?= base_url('public/assets/img/default.png') ?>" alt="Photo" class="photo" crossorigin="anonymous">
	      <?php endif; ?>
      </div>

      <!-- Info -->
      <div class="text-center text-black mb-1">
        <h4 class="mb-1 fw-bold"><?= esc($student['student_name']) ?></h4>
        <p class="mb-0 fw-semibold">STUDENT</p>
        <p class="mb-0 fw-semibold">ID NO: <?= esc($student['id']) ?></p>
        <p class="mb-0">Blood Group: <?= esc($student['blood_group']) ?></p>
      
      </div>

      <!-- Signature -->
      <div class="d-flex justify-content-end align-items-end mt-auto">
        <div class="text-end">
          <?php if (!empty($student['signature'])): ?>
            <img src="<?= esc($student['signature']) ?>" alt="Signature" class="signature mb-1" />
          <?php else: ?>
            <div class="signature mb-1" style="background:#ccc;width:100px;height:30px;">[Signature]</div>
          <?php endif; ?>
          <div class="small text-muted">Authorized Signature</div>
        </div>
      </div>
    </div>

    <!-- BACK -->
    <div id="card-back" class="id-card" style="background-image: url('<?= base_url("public/assets/img/bg-back.png") ?>');">
      <!-- QR Code -->
      <div class="text-center mb-3">
        <img
          src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=ID:<?= urlencode($student['id']) ?>-BACK"
          class="qr-img"
          alt="QR Back"
        />
      </div>

      <!-- Emergency Contact -->
      <h5 class="text-center fw-bold text-white">Emergency Contact</h5>
      <h6 class="text-center text-white"><?= esc($student['phone']) ?></h6>
      <h6 class="text-center text-white">s115832mul@gmail.com</h6>
      <br><br>

      <!-- Notes -->
      <div class="mt-3 text-white small px-3">
        <strong>Note:</strong>
        <ul class="mt-1 mb-2 ps-3" style="list-style-type: disc;">
          <li>This card is used for attendance</li>
          <li>Used as an admit card</li>
          <li>Required for online activities</li>
          <li>Please return the card if found</li>
        </ul>
      </div>

      <div class="text-center small text-white mt-2"><?= esc($student['school_name']) ?></div>      
      <div class="text-center small text-white mt-1">Keshabpur, Jessor</div>
    </div>
  </div>

  <!-- Download Buttons -->
  <div class="text-center mt-4">
    <button class="btn btn-primary me-3" onclick="downloadCard('card-front', 'front_<?= $student['id'] ?>.jpg')">Download Front</button>
    <button class="btn btn-secondary" onclick="downloadCard('card-back', 'back_<?= $student['id'] ?>.jpg')">Download Back</button>
  </div>
</div>

<!-- html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadCard(id, filename) {
  html2canvas(document.getElementById(id), {
    scale: 2,
    useCORS: true
  }).then(canvas => {
    const link = document.createElement('a');
    link.download = filename;
    link.href = canvas.toDataURL("image/jpeg", 0.95);
    link.click();
  });
}
</script>

<?= $this->endSection(); ?>
