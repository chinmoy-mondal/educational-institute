<?php if ($pager->hasPrevious() || $pager->hasNext()): ?>
<nav aria-label="Pagination">
  <ul class="pagination justify-content-center">

    <!-- Previous Link -->
    <?php if ($pager->hasPrevious()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPreviousPage() ?>">Previous</a>
      </li>
    <?php endif; ?>

    <!-- Page Number Links -->
    <?php foreach ($pager->links() as $link): ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
      </li>
    <?php endforeach; ?>

    <!-- Next Link -->
    <?php if ($pager->hasNext()): ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNextPage() ?>">Next</a>
      </li>
    <?php endif; ?>

  </ul>
</nav>
<?php endif; ?>
