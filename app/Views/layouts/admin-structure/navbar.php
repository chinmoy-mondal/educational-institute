<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <?php foreach ($navbarItems as $item): ?>
    <li class="nav-item d-none d-sm-inline-block">
        <a href="<?= $item['url'] ?>" class="nav-link"><?= esc($item['label']) ?></a>
    </li>
    <?php endforeach; ?>
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
