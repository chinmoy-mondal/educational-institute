<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
  <?php
    $segment = 'default';
    $currentPage = $pager->getCurrentPage($segment);
    $totalPages  = $pager->getPageCount($segment);
    $surround = 5; // 5 pages before and after
    $start = max(1, $currentPage - $surround);
    $end   = min($totalPages, $currentPage + $surround);
  ?>
  <nav>
    <ul class="pagination justify-content-center">

      <!-- First & Prev -->
      <?php if ($pager->hasPrevious($segment)): ?>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getFirst($segment) ?>">First</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getPreviousPage($segment) ?>">&laquo;</a>
        </li>
      <?php endif ?>

      <!-- Left dots -->
      <?php if ($start > 1): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif ?>

      <!-- Page Numbers -->
      <?php for ($i = $start; $i <= $end; $i++): ?>
        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
          <a class="page-link" href="<?= $pager->getPageURI($i, $segment) ?>"><?= $i ?></a>
        </li>
      <?php endfor ?>

      <!-- Right dots -->
      <?php if ($end < $totalPages): ?>
        <li class="page-item disabled"><span class="page-link">…</span></li>
      <?php endif ?>

      <!-- Next & Last -->
      <?php if ($pager->hasNext($segment)): ?>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getNextPage($segment) ?>">&raquo;</a>
        </li>
        <li class="page-item">
          <a class="page-link" href="<?= $pager->getLast($segment) ?>">Last</a>
        </li>
      <?php endif ?>
    </ul>
  </nav>
<?php endif ?>
