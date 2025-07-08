<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
<nav>
  <ul class="pagination justify-content-center">
    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getPreviousPage() ?>">&laquo;</a></li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
      </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()): ?>
      <li class="page-item"><a class="page-link" href="<?= $pager->getNextPage() ?>">&raquo;</a></li>
    <?php endif ?>
  </ul>
</nav>
<?php endif ?>
