<?php
$currentPage = $pager->getCurrentPage('default');
$pageCount   = $pager->getPageCount('default');
$segment     = $pager->getSegment('default');
$surround    = 5; // Show 5 pages before and after current
$start       = max(1, $currentPage - $surround);
$end         = min($pageCount, $currentPage + $surround);
?>

<?php if ($pager->hasPages('default')): ?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

    <!-- First & Previous -->
    <?php if ($pager->hasPrevious('default')): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getFirst('default') ?>">First</a></li>
      <li class="page-item"><a class="page-link" href="<?= $pager->getPreviousPage('default') ?>">&laquo;</a></li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">First</span></li>
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    <?php endif; ?>

    <!-- Page Numbers -->
    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
        <a class="page-link" href="<?= $pager->getPageURI($i, 'default') ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <!-- Next & Last -->
    <?php if ($pager->hasNext('default')): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getNextPage('default') ?>">&raquo;</a></li>
      <li class="page-item"><a class="page-link" href="<?= $pager->getLast('default') ?>">Last</a></li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
      <li class="page-item disabled"><span class="page-link">Last</span></li>
    <?php endif; ?>

  </ul>
</nav>
<?php endif; ?>
