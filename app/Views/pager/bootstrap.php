<?php if ($pager->hasPrevious()): ?>
<nav>
  <ul class="pagination justify-content-center">

    <li class="page-item">
      <a class="page-link" href="<?= $pager->getFirst() ?>">First</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="<?= $pager->getPreviousPage() ?>">&laquo;</a>
    </li>
<?php endif ?>

<?php foreach ($pager->links() as $link): ?>
  <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
    <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
  </li>
<?php endforeach ?>

<?php if ($pager->hasNext()): ?>
    <li class="page-item">
      <a class="page-link" href="<?= $pager->getNextPage() ?>">&raquo;</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="<?= $pager->getLast() ?>">Last</a>
    </li>
  </ul>
</nav>
<?php endif ?>
