<style>
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    padding-top: 20px;
    z-index: 1050;
    overflow-y: auto;
    transition: 0.3s;
}

/* LOGO */
.sidebar h4 {
    color: #fff;
    text-align: center;
    margin-bottom: 25px;
    font-weight: 600;
}

/* MAIN MENU */
.sidebar a {
    color: #cbd5e1;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    text-decoration: none;
    border-radius: 10px;
    margin: 5px 10px;
    transition: 0.2s;
    font-size: 15px;
}

/* HOVER + ACTIVE */
.sidebar a:hover,
.sidebar a.active {
    background: linear-gradient(90deg, #6366f1, #22c55e);
    color: #fff;
    transform: translateX(5px);
}

/* CATEGORY TITLE */
.sidebar .category-title {
    color: #94a3b8;
    font-size: 11px;
    font-weight: 600;
    padding: 14px 20px 5px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* SUB MENU */
.sidebar .submenu a {
    padding-left: 45px;
    font-size: 14px;
    margin-top: 2px;
    margin-bottom: 2px;
}

/* ICON */
.sidebar i {
    margin-right: 10px;
}

/* CARET */
.sidebar .caret {
    margin-left: auto;
    font-size: 12px;
}

/* MOBILE */
@media(max-width:768px) {

    .sidebar {
        transform: translateX(-100%);
    }

    .sidebar.active {
        transform: translateX(0);
    }
}
</style>

<div class="sidebar" id="sidebar">

    <h4>🏥 Clinic Pro</h4>

    <?php foreach (($sidebarCategories ?? []) as $cat): ?>

    <!-- SINGLE MENU -->
    <?php if (($cat['type'] ?? '') === 'single'): ?>

    <a href="<?= base_url($cat['url'] ?? '#') ?>"
        class="<?= (($activeSection ?? '') === ($cat['section'] ?? '')) ? 'active' : '' ?>">

        <span>
            <i class="<?= esc($cat['icon'] ?? '') ?>"></i>
            <?= esc($cat['label'] ?? '') ?>
        </span>

    </a>

    <?php endif; ?>



    <!-- CATEGORY -->
    <?php if (($cat['type'] ?? '') === 'category'): ?>

    <?php
            $collapseId = 'menu_' . md5($cat['label']);
            $children   = $sidebarSubItems[$cat['label']] ?? [];

            // Auto open if active child exists
            $isOpen = false;

            foreach ($children as $child) {
                if (($activeSection ?? '') === ($child['section'] ?? '')) {
                    $isOpen = true;
                }
            }
            ?>

    <!-- CATEGORY BUTTON -->
    <a data-bs-toggle="collapse" href="#<?= $collapseId ?>" role="button"
        aria-expanded="<?= $isOpen ? 'true' : 'false' ?>" class="<?= $isOpen ? 'active' : '' ?>">

        <span>
            <i class="<?= esc($cat['icon'] ?? '') ?>"></i>
            <?= esc($cat['label'] ?? '') ?>
        </span>

        <i class="fas fa-chevron-down caret"></i>
    </a>

    <!-- SUBMENU -->
    <div class="collapse <?= $isOpen ? 'show' : '' ?>" id="<?= $collapseId ?>">

        <div class="submenu">

            <?php foreach ($children as $child): ?>

            <a href="<?= base_url($child['url'] ?? '#') ?>"
                class="<?= (($activeSection ?? '') === ($child['section'] ?? '')) ? 'active' : '' ?>">

                <?= esc($child['label'] ?? '') ?>

            </a>

            <?php endforeach; ?>

        </div>

    </div>

    <?php endif; ?>

    <?php endforeach; ?>

</div>