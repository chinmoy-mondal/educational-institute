
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
    <?php if (!empty($newUsers)) : ?>
        <?php foreach ($newUsers as $user) : ?>
            <tr>
                <td>
                    <img src="<?= !empty($user['photo']) 
                        ? base_url('uploads/' . $user['photo']) 
                        : base_url('public/assets/img/default.png') ?>" 
                        alt="User Photo" width="50">
                </td>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['designation']) ?></td>
                <td><?= esc($user['subject']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= esc($user['phone']) ?></td>
                <td><?= ucfirst(esc($user['gender'])) ?></td>
                <td>
                    <a href="<?= base_url('user_permit/' . $user['id']) ?>" class="btn btn-success btn-sm">Permit</a>
                    <a href="<?= base_url('user_delete/' . $user['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="8" class="text-center">No new users found.</td>
        </tr>
    <?php endif; ?>
</tbody>



          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?= $this->endSection() ?>
