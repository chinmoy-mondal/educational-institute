<!-- Footer -->
<footer class="bg-dark text-light pt-4">
    <div class="container">
        <div class="row">
            <!-- Contact Info -->
            <div class="col-md-4">
                <h5>Contact Us</h5>
                <p><?= esc(env('school.address')) ?></p>
                <p>Email: <?= esc(env('school.email')) ?></p>
                <p>Phone: <?= esc(env('school.phone')) ?></p>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-light">Home</a></li>
                    <li><a href="#" class="text-light">Admissions</a></li>
                    <li><a href="#" class="text-light">Academics</a></li>
                    <li><a href="#" class="text-light">Contact Us</a></li>
                </ul>
            </div>

            <!-- Google Map Embed -->
            <div class="col-md-4">
                <h5>Our Location</h5>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d228.88491672729666!2d88.8230319!3d23.3824766!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fed57ee9d2e209%3A0x9d6017e1bba86696!2sDattanagar%20SM%20Farm%20Secondary%20School!5e0!3m2!1sen!2sbd!4v1771370373344!5m2!1sen!2sbd"
                    width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>

        <div class="text-center mt-3 pb-3">
            <p>&copy; 2025 School Name. All Rights Reserved.</p>
        </div>
    </div>
</footer>