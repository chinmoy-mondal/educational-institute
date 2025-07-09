<?php if ($pager->hasPages()): ?>
    <nav aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <!-- First -->
            <?php if ($pager->hasPrevious()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getFirst() ?>">First</a>
                </li>
            <?php endif; ?>

            <!-- Previous -->
            <?php if ($pager->hasPrevious()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getPreviousPage() ?>">&laquo;</a>
                </li>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php foreach ($pager->links() as $link): ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $link['uri'] ?>">
                        <?= $link['title'] ?>
                    </a>
                </li>
            <?php endforeach ?>

            <!-- Next -->
            <?php if ($pager->hasNext()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getNextPage() ?>">&raquo;</a>
                </li>
            <?php endif; ?>

            <!-- Last -->
            <?php if ($pager->hasNext()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getLast() ?>">Last</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
<?php endif ?>
