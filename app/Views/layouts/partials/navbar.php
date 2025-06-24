<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('dashboard') ?>" class="nav-link">Dashboard</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('calendar') ?>" class="nav-link">Calendar</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?= base_url('ad-result') ?>" class="nav-link">Calendar</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Profile Button -->
    <li class="nav-item">
      <a href="<?= base_url('profile') ?>" class="nav-link">
        <i class="fas fa-user"></i> Profile
      </a>
    </li>

    <!-- Logout Button -->
    <li class="nav-item">
      <a href="<?= base_url('logout') ?>" class="nav-link text-danger">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
    </li>
  </ul>
</nav>
