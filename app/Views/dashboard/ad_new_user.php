

<?= $this->include("layouts/admin") ?>
<?= $this->section("content") ?>

<section class="content">
  <div class="container-fluid">
    <div class="card card-primary card-outline shadow">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title mb-0"><i class="fas fa-chalkboard-teacher"></i>New Users List</h3>
      </div>

      <div class="card-body">
        <div class="table-responsive"><?= $total_newUsers ?>
          <table id="teacherTable" class="table table-bordered table-hover table-striped">
            <thead class="bg-navy text-center">
              <tr>
                <th>Photo</th>
                <th>Name</th>
                <th>Designation</th>
                <th>Subject</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>



<?php 
if (!empty($newUsers)) {
    foreach ($newUsers as $user) {
        echo "Name: " . $user['name'] . "<br>";
        echo "Designation: " . $user['designation'] . "<br>";
        echo "Subject: " . $user['subject'] . "<br>";
        echo "Email: " . $user['email'] . "<br>";
        echo "Phone: " . $user['phone'] . "<br>";
        echo "Gender: " . ucfirst($user['gender']) . "<br>";
        echo "Photo URL: " . (!empty($user['photo']) 
            ? base_url('uploads/' . $user['photo']) 
            : base_url('public/assets/img/default.png')) . "<br>";
        echo "Permit URL: " . base_url('user_permit/' . $user['id']) . "<br>";
        echo "Delete URL: " . base_url('user_delete/' . $user['id']) . "<br>";
        echo "-----------------------------<br><br>";
    }
} else {
    echo "No new users found.<br>";
}

?>



          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
