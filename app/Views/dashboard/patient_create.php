<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <h4 class="mb-4">➕ Add New Patient</h4>

            <form action="<?= base_url('dashboard/patients/store') ?>" method="post">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label>Age</label>
                        <input type="number" name="age" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>NID</label>
                        <input type="text" name="nid" class="form-control">
                    </div>

                    <div class="col-12">
                        <label>Address</label>
                        <textarea name="address" class="form-control" rows="2"></textarea>
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">
                        💾 Save Patient
                    </button>

                    <a href="<?= base_url('dashboard/patients') ?>" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

<?= $this->endSection() ?>