<form method="get" class="mb-3">
    <input type="text" name="search" class="form-control" placeholder="Search drug..." value="<?= esc($search) ?>">
    <button type="submit" class="btn btn-primary mt-2">Search</button>
</form>

<div id="drugList">
    <?php if(!empty($drugs)): ?>
        <?php foreach($drugs as $d): ?>
            <div class="drug-item">
                <b><?= esc($d['drug_type']) ?>. <?= esc($d['drug_name']) ?></b> — <?= esc($d['quantity'] ?? '') ?> <?= esc($d['unit_type'] ?? '') ?>
                <div class="small-text"><?= esc($d['group_name'] ?? '') ?> | <?= esc($d['company'] ?? '') ?></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-muted">No results found</div>
    <?php endif; ?>
</div>