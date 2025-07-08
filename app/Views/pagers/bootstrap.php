<?php if ($pager->links()): ?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

    <!-- First & Previous -->
    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item">
        <a href="<?= $pager->getFirst() ?>" class="page-link">First</a>
      </li>
      <li class="page-item">
        <a href="<?= $pager->getPrevious() ?>" class="page-link">&laquo;</a>
      </li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">First</span></li>
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    <?php endif; ?>

    <!-- Page numbers -->
    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
      </li>
    <?php endforeach; ?>

    <!-- Next & Last -->
    <?php if ($pager->hasNext()): ?>
      <li class="page-item">
        <a href="<?= $pager->getNext() ?>" class="page-link">&raquo;</a>
      </li>
      <li class="page-item">
        <a href="<?= $pager->getLast() ?>" class="page-link">Last</a>
      </li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
      <li class="page-item disabled"><span class="page-link">Last</span></li>
    <?php endif; ?>

  </ul>
</nav>
<?php endif; ?>
