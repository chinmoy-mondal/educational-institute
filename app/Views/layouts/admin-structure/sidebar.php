<style>
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(180deg, #0f172a, #1e293b);
    padding-top: 20px;
    z-index: 1050;
}

.sidebar h4 {
    color: #fff;
    text-align: center;
    margin-bottom: 25px;
}

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

.sidebar i {
    margin-right: 8px;
}
</style>

<div class="sidebar">

    <h4>🏥 Clinic Pro</h4>

    <?php foreach ($sidebarItems ?? [] as $item): ?>

    <a href="<?= base_url($item['url']) ?>"
        class="<?= (isset($activeSection) && $activeSection === $item['section']) ? 'active' : '' ?>">

        <i class="<?= esc($item['icon']) ?>"></i>
        <?= esc($item['label']) ?>
    </a>

    <?php endforeach; ?>

</div>