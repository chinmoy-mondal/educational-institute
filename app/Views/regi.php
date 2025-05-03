<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("structure/header"); ?>
        </div>



        <div class="container content">

    <div class="row justify-content-center">
      <div class="col-md-8">
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



<style>
    .head-sir-message {
        background: url('<?= base_url("public/assets/img/head-sir-bg.jpg"); ?>') no-repeat center center/cover;
        position: relative;
        padding: 80px 0;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .head-sir-message .container {
        position: relative;
        z-index: 2;
    }

    .sir-image img {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 10px;
        border: 5px solid #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    .head-sir-message h2, .head-sir-message p {
        color: white;
    }

    @media (max-width: 768px) {
        .sir-image img {
            height: 250px;
        }

        .head-sir-message h2 {
            font-size: 1.8rem;
        }

        .head-sir-message p {
            font-size: 1rem;
        }
    }
</style>
<!--end-->




        </div>

        <?= $this->include("structure/footer"); ?>

<?= $this->endSection(); ?>
  