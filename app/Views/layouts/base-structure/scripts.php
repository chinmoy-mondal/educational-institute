<!-- Bootstrap -->
<script src="<?= base_url('public/assets/js/bootstrap.bundle.min.js') ?>"></script>

<!-- Global JS -->
<script>
    console.log("Clinic System Loaded Successfully");

    // optional: mobile menu auto close improvement
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            let menu = document.querySelector('.navbar-collapse');
            if (menu.classList.contains('show')) {
                new bootstrap.Collapse(menu).toggle();
            }
        });
    });
</script>

</body>

</html>