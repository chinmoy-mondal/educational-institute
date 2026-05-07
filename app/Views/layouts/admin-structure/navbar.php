<style>
.navbar {
    margin-left: 260px;
    background: white;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
}
</style>

<nav class="navbar px-3 d-flex justify-content-between">

    <button class="btn btn-light d-md-none" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <h5 class="mb-0"><?= $title ?? 'Dashboard' ?></h5>

    <div class="dropdown">
        <a class="text-dark dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown">
            <img src="https://i.pravatar.cc/40?img=5" class="rounded-circle me-2" width="35">
            Admin
        </a>

        <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li>
                <hr>
            </li>
            <li>
                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                    Logout
                </a>
            </li>
        </ul>
    </div>

</nav>