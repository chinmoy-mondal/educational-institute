<?php if ($pager->links()): ?>
  <nav>
    <ul class="pagination justify-content-center">

      <!-- First & Prev -->
      <?php if ($pager->hasPrevious()): ?>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getFirst() ?>">First</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getPreviousPage() ?>">&laquo;</a>
        </li>
      <?php endif ?>

      <?php
        $currentPage = $pager->getCurrentPage('default');
        $pageCount = $pager->getPageCount('default');
        $max = 10;
        $half = floor($max / 2);
        $start = max(1, $currentPage - $half);
        $end = min($pageCount, $start + $max - 1);
        if ($end - $start < $max - 1) {
            $start = max(1, $end - $max + 1);
        }
      ?>

      <?php if ($start > 1): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>

      <?php foreach (range($start, $end) as $i): ?>
        <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
          <a class="page-link" href="<?= $pager->getPageURI($i, 'default') ?>"><?= $i ?></a>
        </li>
      <?php endforeach ?>

      <?php if ($end < $pageCount): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif; ?>

      <!-- Next & Last -->
      <?php if ($pager->hasNext()): ?>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getNextPage() ?>">&raquo;</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getLast() ?>">Last</a>
        </li>
      <?php endif ?>

    </ul>
  </nav>
<?php endif ?>
