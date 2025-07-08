<?php
$totalPages   = $pager->getPageCount();
$currentPage  = $pager->getCurrentPage();
$surround     = 5;

$start = max(1, $currentPage - $surround);
$end   = min($totalPages, $currentPage + $surround);
?>

<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
<nav>
  <ul class="pagination justify-content-center">

    <!-- First -->
    <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="First">First</a>
    </li>

    <!-- Previous -->
    <li class="page-item <?= !$pager->hasPrevious() ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">&laquo;</a>
    </li>

    <!-- Numbered Links -->
    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
        <a class="page-link" href="<?= $pager->getPageURI($i) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <!-- Next -->
    <li class="page-item <?= !$pager->hasNext() ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">&raquo;</a>
    </li>

    <!-- Last -->
    <li class="page-item <?= $currentPage == $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Last">Last</a>
    </li>

  </ul>
</nav>
<?php endif ?>
