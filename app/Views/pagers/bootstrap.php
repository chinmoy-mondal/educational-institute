<?php if ($pager->hasPrevious() || $pager->hasNext() || count($pager->links())) : ?>
<div class="container mt-3">
  <ul class="pagination justify-content-center">

    <?php if ($pager->hasPrevious()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Previous">
          &laquo; Previous
        </a>
      </li>
    <?php endif; ?>

    <?php foreach ($pager->links() as $link) : ?>
      <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
        <a class="page-link" href="<?= $link['uri'] ?>">
          <?= $link['title'] ?>
        </a>
      </li>
    <?php endforeach; ?>

    <?php if ($pager->hasNext()) : ?>
      <li class="page-item">
        <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Next">
          Next &raquo;
        </a>
      </li>
    <?php endif; ?>

  </ul>
</div>
<?php endif; ?>
