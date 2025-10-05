<?= $this->extend("layouts/base.php") ?>

<?= $this->section("content") ?>

<!-- Fixed Header -->
<div class="fixed-header">
    <?= $this->include("layouts/base-structure/header") ?>
</div>

<!-- Page Title -->
<div class="page-title text-center py-5 bg-light">
    <div class="container">
        <h2 class="fw-bold">School Notices</h2>
        <p class="text-muted">Stay updated with our latest announcements</p>
    </div>
</div>

<!-- Notice Section -->
<section class="notice-section py-5">
    <div class="container">
        <div class="card shadow-sm rounded-4 p-4">
            <h4 class="mb-4 border-bottom pb-2">Recent Notices</h4>

            <div class="list-group">

                <!-- 🆕 New Notice (appears first) -->
                <div class="list-group-item py-3 bg-light">
                    <h5 class="mb-1">📰 New Notice: Half-Yearly Exam Result Published</h5>
                    <p class="mb-1 text-muted">
                        The Half-Yearly Examination Results for all classes have been published. 
                        Students can collect their report cards from class teachers between 10 AM – 1 PM.
                    </p>
                    <small class="text-secondary">Date: October 5, 2025</small>
                </div>

                <!-- Previous Notices -->
                <div class="list-group-item py-3">
                    <h5 class="mb-1">📢 Mid-Term Examination Routine Published</h5>
                    <p class="mb-1 text-muted">
                        All students are informed that the Mid-Term Examination Routine for Classes 6 to 10 
                        has been published on the notice board and school website.
                    </p>
                    <small class="text-secondary">Date: October 3, 2025</small>
                </div>

                <div class="list-group-item py-3">
                    <h5 class="mb-1">🎓 Admission Open for Class 6 (Session 2026)</h5>
                    <p class="mb-1 text-muted">
                        Applications are now open for admission to Class 6 for the 2026 session. 
                        Please collect admission forms from the school office within office hours.
                    </p>
                    <small class="text-secondary">Date: September 28, 2025</small>
                </div>

                <div class="list-group-item py-3">
                    <h5 class="mb-1">🏫 Annual Sports Day</h5>
                    <p class="mb-1 text-muted">
                        The Annual Sports Day will be held on November 20, 2025. 
                        All students must participate in at least one event. 
                        Details will be announced later.
                    </p>
                    <small class="text-secondary">Date: September 15, 2025</small>
                </div>

                <div class="list-group-item py-3">
                    <h5 class="mb-1">📄 Guardians Meeting</h5>
                    <p class="mb-1 text-muted">
                        A meeting for all guardians of Class 8 and 9 students will be held 
                        in the auditorium at 10:00 AM on October 10, 2025.
                    </p>
                    <small class="text-secondary">Date: September 10, 2025</small>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<?= $this->include("layouts/base-structure/footer") ?>

<?= $this->endSection() ?>