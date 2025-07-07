










<?= $this->include("../layouts/base-structure/base.php") ?>

<?= $this->section("content"); ?>

     <!--  Fixed Wrapper for Navbar -->
        <div class="fixed-header">
            <?= $this->include("../layouts/base-structure/header"); ?>
        </div>
        <div class="container content">







<!--start-->
<section class="head-sir-message py-5 position-relative">
    <div class="overlay"></div>
    <div class="container position-relative text-white text-center">
        <div class="row align-items-center">
            <!-- Image Section -->
            <div class="col-lg-4 text-center">
                <div class="sir-image">
                    <img src="<?= base_url('public/assets/img/headsir.jpg'); ?>" alt="Head Sir" class="img-fluid">
                </div>
            </div>
            
            <!-- Message Section -->
            <div class="col-lg-8 text-lg-start">
                <h2 class="fw-bold">Message from the Head Sir</h2>
                <p class="fst-italic">"Education is the most powerful weapon which you can use to change the world." – Nelson Mandela</p>
                <p>
                    It is my great pleasure to welcome you to our school, a place where young minds are nurtured with knowledge, values, and a strong sense of purpose. We believe that education is not just about academic excellence but also about character building, critical thinking, and lifelong learning. 
                </p>
                <p>
                    Our dedicated faculty and staff work tirelessly to create an environment that fosters curiosity, innovation, and leadership. We are committed to shaping our students into responsible individuals who contribute positively to society. Through a well-structured curriculum and diverse extracurricular activities, we aim to provide a holistic education that prepares students for the challenges of the future.
                </p>
                <p>
                    I encourage every student to embrace learning with enthusiasm and determination. Together, let’s build a strong foundation for a brighter tomorrow.
                </p>
                <h5 class="fw-bold mt-3">- [Head Sir's Name]</h5>
                <p class="fst-italic">Head of School</p>
            </div>
        </div>
    </div>
</section>

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


        <?= $this->include("../layouts/base-structure/footer"); ?>

<?= $this->endSection(); ?>
  
