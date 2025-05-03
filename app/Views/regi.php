<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("structure/header"); ?>
        </div>



        <div class="container content">

    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg rounded">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Register</h3>
            <form action="#" method="post">
              <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="#">Login here</a></p>
          </div>
        </div>
      </div>
    </div>





        </div>

        <?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>
  