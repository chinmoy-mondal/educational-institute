<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Clinic Dashboard') ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background: #f1f5f9;
    }

    /* =========================
       SIDEBAR
    ========================== */

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

    .sidebar h4 {
        color: #fff;
        text-align: center;
        margin-bottom: 25px;
        font-weight: 600;
    }

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

    .sidebar a:hover,
    .sidebar a.active {
        background: linear-gradient(90deg, #6366f1, #22c55e);
        color: #fff;
        transform: translateX(5px);
    }

    .sidebar .submenu a {
        padding-left: 45px;
        font-size: 14px;
    }

    .sidebar i {
        margin-right: 10px;
    }

    .caret {
        font-size: 12px;
    }

    /* =========================
       NAVBAR
    ========================== */

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
        margin-right: 10px;
        object-fit: cover;
    }

    /* =========================
       CONTENT
    ========================== */

    .content {
        margin-left: 260px;
        padding: 25px;
        transition: 0.3s;
    }

    /* =========================
       MOBILE
    ========================== */

    @media(max-width:768px) {

        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .top-navbar {
            margin-left: 0;
            padding: 0 15px;
        }

        .content {
            margin-left: 0;
            padding: 15px;
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
</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================== -->

    <div class="sidebar" id="sidebar">

        <h4>🏥 Clinic Pro</h4>

        <?php foreach (($sidebarCategories ?? []) as $cat): ?>

        <!-- SINGLE -->
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

                $isOpen = false;

                foreach ($children as $child) {
                    if (($activeSection ?? '') === ($child['section'] ?? '')) {
                        $isOpen = true;
                    }
                }
                ?>

        <a data-bs-toggle="collapse" href="#<?= $collapseId ?>" role="button" class="<?= $isOpen ? 'active' : '' ?>">

            <span>
                <i class="<?= esc($cat['icon'] ?? '') ?>"></i>
                <?= esc($cat['label'] ?? '') ?>
            </span>

            <i class="fas fa-chevron-down caret"></i>

        </a>

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

    <!-- =========================
         NAVBAR
    ========================== -->

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

    <!-- =========================
         CONTENT
    ========================== -->

    <div class="content">

        <?= $this->renderSection('content') ?>

    </div>

    <!-- =========================
         SCRIPTS
    ========================== -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
    }
    </script>

</body>

</html>