<?php if ($pager->links()): ?>
<nav>
    <ul class="pagination justify-content-center">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a href="<?= $pager->getPreviousPage() ?>" class="page-link">&laquo;</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a href="<?= $pager->getNextPage() ?>" class="page-link">&raquo;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>
<?php endif ?>
