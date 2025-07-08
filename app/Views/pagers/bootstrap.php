<?php if ($pager->hasPages()): ?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

    <!-- First & Previous -->
    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getFirst() ?>">First</a></li>
      <li class="page-item"><a class="page-link" href="<?= $pager->getPrevious() ?>">&laquo;</a></li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">First</span></li>
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    <?php endif; ?>

    <?php
      $currentPage = $pager->getCurrentPage();
      $totalPages  = $pager->getPageCount();
      $range = 2; // Show 2 pages before and after current (total visible = 5 max)

      $start = max(1, $currentPage - $range);
      $end   = min($totalPages, $currentPage + $range);

      if ($start > 1):
    ?>
      <li class="page-item disabled"><span class="page-link">...</span></li>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
        <a class="page-link" href="<?= $pager->getPageURI($i) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $totalPages): ?>
      <li class="page-item disabled"><span class="page-link">...</span></li>
    <?php endif; ?>

    <!-- Next & Last -->
    <?php if ($pager->hasNext()): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getNext() ?>">&raquo;</a></li>
      <li class="page-item"><a class="page-link" href="<?= $pager->getLast() ?>">Last</a></li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
      <li class="page-item disabled"><span class="page-link">Last</span></li>
    <?php endif; ?>

  </ul>
</nav>
<?php endif; ?>
