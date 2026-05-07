<style>
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    padding-top: 20px;
    z-index: 1050;
    overflow-y: auto;
}

.sidebar h4 {
    color: #fff;
    text-align: center;
    margin-bottom: 25px;
}

/* MAIN LINK */
.sidebar a {
    color: #cbd5e1;
    padding: 12px 20px;
    display: block;
    text-decoration: none;
    border-radius: 10px;
    margin: 5px 10px;
    transition: 0.2s;
}

.sidebar a:hover,
.sidebar a.active {
    background: linear-gradient(90deg, #6366f1, #22c55e);
    color: white;
    transform: translateX(5px);
}

/* CATEGORY TITLE */
.sidebar .category {
    color: #94a3b8;
    font-size: 12px;
    padding: 10px 20px 5px;
    text-transform: uppercase;
}

/* SUB MENU */
.sidebar .submenu a {
    padding-left: 35px;
    font-size: 14px;
}

/* ICON */
.sidebar i {
    margin-right: 8px;
}
</style>

<div class="sidebar">

    <h4>🏥 Clinic Pro</h4>

    <?php foreach ($sidebarItems ?? [] as $item): ?>

    <!-- SINGLE ITEM -->
    <?php if (($item['type'] ?? '') === 'single'): ?>

    <a href="<?= base_url($item['url'] ?? '#') ?>"
        class="<?= (($activeSection ?? '') === ($item['section'] ?? '')) ? 'active' : '' ?>">

        <i class="<?= esc($item['icon'] ?? '') ?>"></i>
        <?= esc($item['label'] ?? '') ?>
    </a>

    <?php endif; ?>


    <!-- CATEGORY -->
    <?php if (($item['type'] ?? '') === 'category'): ?>

    <div class="category">
        <i class="<?= esc($item['icon'] ?? '') ?>"></i>
        <?= esc($item['label'] ?? '') ?>
    </div>

    <?php $children = $item['children'] ?? []; ?>

    <?php if (!empty($children) && is_array($children)): ?>

    <div class="submenu">

        <?php foreach ($children as $child): ?>

        <a href="<?= base_url($child['url'] ?? '#') ?>"
            class="<?= (($activeSection ?? '') === ($child['section'] ?? '')) ? 'active' : '' ?>">

            <?= esc($child['label'] ?? '') ?>
        </a>

        <?php endforeach; ?>

    </div>

    <?php endif; ?>

    <?php endif; ?>

    <?php endforeach; ?>

</div>