<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow border-0 rounded-3">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Add Transaction</h5>
                </div>
                <div class="card-body">

                    <!-- ✅ Earnings & Cost Summary -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card text-center border-success">
                                <div class="card-body">
                                    <h6 class="text-success">Total Earn</h6>
                                    <h4 class="fw-bold text-success">
                                        ৳ <?= number_format($totalEarn ?? 0, 2) ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card text-center border-danger">
                                <div class="card-body">
                                    <h6 class="text-danger">Total Cost</h6>
                                    <h4 class="fw-bold text-danger">
                                        ৳ <?= number_format($totalCost ?? 0, 2) ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ✅ End Summary -->

                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form id="transactionForm" action="<?= base_url('dashboard/transactions') ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <div class="form-group mb-2">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" class="form-control" id="transaction_id" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="sender_name">Sender Name</label>
                            <input type="text" name="sender_name" class="form-control" id="sender_name" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="receiver_name">Receiver Name</label>
                            <input type="text" name="receiver_name" class="form-control" id="receiver_name" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" id="amount" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="purpose">Purpose</label>
                            <select name="purpose" id="purpose" class="form-control" required>
                                <option value="">Select Purpose</option>
                                <?php foreach ($purposes as $p): ?>
                                    <option value="<?= esc($p['title']) ?>"><?= esc($p['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description"></textarea>
                        </div>

                        <div class="card-footer d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Add Transaction</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>