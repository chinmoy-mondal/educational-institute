<style>
.top-navbar {

    margin-left: 260px;

    height: 65px;

    background: #fff;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 20px;

    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);

    position: sticky;
    top: 0;

    z-index: 1040;

    transition: 0.3s;
}

.left-side {
    display: flex;
    align-items: center;
    gap: 12px;
}

.left-side h5 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.menu-btn {
    width: 42px;
    height: 42px;

    border: none;

    border-radius: 10px;

    background: #f1f5f9;

    display: none;
}

.profile-btn {
    display: flex;
    align-items: center;

    text-decoration: none;

    color: #111827;

    cursor: pointer;
}

.profile-btn img {
    width: 38px;
    height: 38px;

    border-radius: 50%;

    object-fit: cover;

    margin-right: 10px;
}

/* MOBILE */
@media(max-width:768px) {

    .top-navbar {
        margin-left: 0;
        padding: 0 15px;
    }

    .menu-btn {
        display: block;
    }

    .profile-btn span {
        display: none;
    }

    .left-side h5 {
        font-size: 17px;
    }
}
</style>

<nav class="top-navbar">

    <div class="left-side">

        <button class="menu-btn" onclick="toggleSidebar()">

            <i class="fas fa-bars"></i>

        </button>

        <h5><?= esc($title ?? 'Dashboard') ?></h5>

    </div>

    <div class="dropdown">

        <a class="profile-btn dropdown-toggle" data-bs-toggle="dropdown">

            <img src="https://i.pravatar.cc/100?img=5">

            <span>
                <?= esc(session()->get('user_name') ?? 'Admin') ?>
            </span>

        </a>

        <ul class="dropdown-menu dropdown-menu-end">

            <li>
                <a class="dropdown-item" href="<?= base_url('dashboard/profile') ?>">

                    <i class="fas fa-user me-2"></i>
                    Profile

                </a>
            </li>

            <li>
                <hr class="dropdown-divider">
            </li>

            <li>
                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">

                    <i class="fas fa-sign-out-alt me-2"></i>
                    Logout

                </a>
            </li>

        </ul>

    </div>

</nav>