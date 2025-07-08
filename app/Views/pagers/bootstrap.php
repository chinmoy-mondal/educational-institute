<?php if ($pager->hasMore() || $pager->getCurrentPage() > 1): ?>
<nav>
    <ul class="pagination">
        <?php if ($pager->getPreviousPageURI()): ?>
            <li class="page-item">
                <a href="<?= $pager->getPreviousPageURI() ?>" class="page-link">&laquo;</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->getNextPageURI()): ?>
            <li class="page-item">
                <a href="<?= $pager->getNextPageURI() ?>" class="page-link">&raquo;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>
<?php endif ?>
