<?php if ($pager->links()): ?>
<nav aria-label="Page navigation">
  <ul class="pagination justify-content-center">

    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getFirst() ?>">First</a></li>
      <li class="page-item"><a class="page-link" href="<?= $pager->getPrevious() ?>">&laquo;</a></li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link">First</span></li>
      <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
      </li>
    <?php endforeach; ?>

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
