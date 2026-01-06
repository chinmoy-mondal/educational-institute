<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- Page Header -->
    <div class="row mb-3">
        <div class="col-sm-6">
            <h1 class="m-0">SMS Balance</h1>
        </div>
        <div class="col-sm-6 text-right">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">SMS Balance</li>
            </ol>
        </div>
    </div>

    <!-- Balance Card -->
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><?= esc($balance) ?></h3>
                    <p>Available SMS Credit</p>
                </div>
                <div class="icon">
                    <i class="fas fa-sms"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Information
                    </h3>
                </div>
                <div class="card-body">
                    <p>
                        This balance is fetched live from <strong>BulkSMSDhaka API</strong>.
                    </p>
                    <ul class="mb-0">
                        <li>Balance updates automatically</li>
                        <li>GET API method used</li>
                        <li>API Response: Numeric value</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>