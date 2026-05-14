<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <!-- HEADER -->
            <div class="mb-4">
                <h4 class="mb-1">➕ Add New Patient</h4>
                <p class="text-muted mb-0">Fill all required patient information</p>
            </div>

            <!-- FORM -->
            <form action="<?= base_url('dashboard/patients/store') ?>" method="post">

                <div class="row g-3">

                    <!-- NAME -->
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter patient name" required>
                    </div>

                    <!-- PHONE -->
                    <div class="col-md-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX" maxlength="11"
                            value="<?= esc($phone ?? '') ?>" required>
                    </div>

                    <!-- AGE -->
                    <div class="col-md-4">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" placeholder="e.g. 25">
                    </div>

                    <!-- GENDER -->
                    <div class="col-md-4">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- EMPTY SPACER -->
                    <div class="col-md-4"></div>

                    <!-- ADDRESS -->
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="Full address..."></textarea>
                    </div>

                </div>

                <!-- ACTION BUTTONS -->
                <div class="mt-4 d-flex gap-2">

                    <button type="submit" class="btn btn-primary px-4">
                        💾 Save Patient
                    </button>

                    <a href="<?= base_url('dashboard/patients') ?>" class="btn btn-outline-secondary px-4">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

<?= $this->endSection() ?>