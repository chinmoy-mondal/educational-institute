

<?= $this->include("layouts/admin") ?>


<?php 
if (!empty($newUsers)) {
    foreach ($newUsers as $user) {
        echo "Name: " . $user['name'] . "<br>";
    }
} else {
    echo "No new users found.<br>";
}

?>
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



          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
