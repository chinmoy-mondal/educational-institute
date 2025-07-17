<?php foreach ($sidebarItems ?? [] as $item): ?>
  <li class="nav-item">
    <a href="<?= $item['url'] ?>"
       class="nav-link <?= ($activeSection === $item['section']) ? 'active' : '' ?>">
      <i class="nav-icon <?= esc($item['icon']) ?>"></i>
      <p><?= esc($item['label']) ?></p>
    </a>
  </li>
<?php endforeach; ?>
