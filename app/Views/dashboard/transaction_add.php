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

                    <!-- Alert placeholder -->
                    <div id="alert-placeholder"></div>

                    <form id="transactionForm" action="<?= base_url('admin/transactions/add') ?>" method="post">
                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">

                        <div class="form-group">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" class="form-control" id="transaction_id" required>
                        </div>

                        <div class="form-group">
                            <label for="sender_name">Sender Name</label>
                            <input type="text" name="sender_name" class="form-control" id="sender_name" required>
                        </div>

                        <div class="form-group">
                            <label for="receiver_name">Receiver Name</label>
                            <input type="text" name="receiver_name" class="form-control" id="receiver_name" required>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" name="amount" class="form-control" id="amount" required>
                        </div>

                        <div class="form-group">
                            <label for="purpose">Purpose</label>
                            <select name="purpose" id="purpose" class="form-control" required>
                                <option value="">Select Purpose</option>
                                <?php foreach ($purposes as $p): ?>
                                    <option value="<?= esc($p['title']) ?>"><?= esc($p['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
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

<!-- Optional JS alert handling -->
<script>
document.getElementById('transactionForm').addEventListener('submit', function(e){
    // Optional: handle AJAX submission here, or just normal form submit
});
</script>

<?= $this->endSection() ?>