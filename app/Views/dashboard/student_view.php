<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="content-header">
  <div class="container-fluid">
    <h1 class="mb-3">Student Profile</h1>
    <a href="<?= site_url('ad-student') ?>" class="btn btn-secondary mb-3">← Back to List</a>
  </div>
</div>

<div class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-body">

        <!-- Profile Header -->
	<div class="row">


<div class="col-md-3 text-center">
  <div class="position-relative d-inline-block" style="max-width: 180px;">

    <?php if (!empty($student['student_pic'])): ?>
      <img src="/<?= esc($student['student_pic']) ?>" alt="Student Photo" class="img-thumbnail w-100">
    <?php else: ?>
      <img src="<?= base_url('public/assets/img/default.png') ?>" alt="No Photo" class="img-thumbnail w-100">
    <?php endif; ?>

    <!-- Rounded Edit Icon on Top-Left -->
	    	        <a href="<?= site_url('admin/students/edit-photo/' . $student['id']) ?>"
					       class="position-absolute top-0 start-0"
						       			              style="
         margin: 6px;
         width: 36px;
         height: 36px;
         display: flex;
         align-items: center;
         justify-content: center;
         background-color: #007bff;
         color: #fff;
         border-radius: 50%;
         box-shadow: 0 2px 6px rgba(0,0,0,0.2);
         text-decoration: none;
       "
       title="Edit Photo">
      <i class="fas fa-edit"></i>
    </a>

  </div>
</div>





	  <div class="col-md-9">
            <h4><?= esc($student['student_name']) ?> (Roll: <?= esc($student['roll']) ?>)</h4>
            <p><strong>Class:</strong> <?= esc($student['class']) ?> | <strong>Section:</strong> <?= esc($student['section']) ?></p>
            <p><strong>Board ID:</strong> <?= esc($student['esif']) ?></p>
            <p><strong>Phone:</strong> <?= esc($student['phone']) ?></p>
            <p><strong>Gender:</strong> <?= esc($student['gender']) ?> | <strong>DOB:</strong> <?= esc($student['dob']) ?></p>
            <p><strong>Religion:</strong> <?= esc($student['religion']) ?> | <strong>Blood Group:</strong> <?= esc($student['blood_group']) ?></p>
            <a href="<?= site_url('admin/students/edit/' . $student['id']) ?>" class="btn btn-success btn-sm mt-2"><i class="fas fa-edit"></i> Edit Profile</a>
          </div>
        </div>

        <hr>

        <!-- Guardian Info -->
        <div class="row mt-3">
          <div class="col-md-6">
            <h5>Father's Information</h5>
            <p><strong>Name:</strong> <?= esc($student['father_name']) ?></p>
            <p><strong>NID:</strong> <?= esc($student['father_nid_number']) ?></p>
          </div>
          <div class="col-md-6">
            <h5>Mother's Information</h5>
            <p><strong>Name:</strong> <?= esc($student['mother_name']) ?></p>
            <p><strong>NID:</strong> <?= esc($student['mother_nid_number']) ?></p>
          </div>
        </div>

        <div class="mt-4">
          <p><strong>Birth Registration No:</strong> <?= esc($student['birth_registration_number']) ?></p>
          <p><small><strong>Created:</strong> <?= esc($student['created_at']) ?> | <strong>Updated:</strong> <?= esc($student['updated_at']) ?></small></p>
        </div>

      </div>
    </div>

  </div>
</div>

<?= $this->endSection() ?>

