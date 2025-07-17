<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?= base_url('dashboard') ?>" class="brand-link">
    <span class="brand-text font-weight-light"><?= esc($title) ?></span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">




<?php foreach ($sidebarItems ?? [] as $item): ?>
  <li class="nav-item">
    <a href="<?= $item['url'] ?>"
       class="nav-link <?= ($activeSection === $item['section']) ? 'active' : '' ?>">
      <i class="nav-icon <?= esc($item['icon']) ?>"></i>
      <p><?= esc($item['label']) ?></p>
    </a>
  </li>
<?php endforeach; ?>
	  <!-- Add more sidebar items similarly -->
	</ul>
    </nav>
  </div>
</aside>

