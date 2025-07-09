<?php if ($pager->links('default')): ?>
    <nav>
        <ul class="pagination justify-content-center">
            <!-- First & Previous -->
            <?php if ($pager->hasPrevious('default')): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getFirst('default') ?>">First</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getPreviousPage('default') ?>">&laquo;</a>
                </li>
            <?php endif ?>

            <?php
                $currentPage = $pager->getCurrentPage('default');
                $pageCount   = $pager->getPageCount('default');
                $maxLinks    = 10;
                $start = max(1, $currentPage - floor($maxLinks / 2));
                $end   = min($pageCount, $start + $maxLinks - 1);
                if ($end - $start < $maxLinks - 1) {
                    $start = max(1, $end - $maxLinks + 1);
                }
            ?>

            <!-- Left ellipsis -->
            <?php if ($start > 1): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php endif ?>

            <!-- Page number buttons -->
            <?php foreach (range($start, $end) as $i): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $pager->getPageURI($i, 'default') ?>"><?= $i ?></a>
                </li>
            <?php endforeach ?>

            <!-- Right ellipsis -->
            <?php if ($end < $pageCount): ?>
                <li class="page-item disabled"><span class="page-link">…</span></li>
            <?php endif ?>

            <!-- Next & Last -->
            <?php if ($pager->hasNext('default')): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getNextPage('default') ?>">&raquo;</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getLast('default') ?>">Last</a>
                </li>
            <?php endif ?>
        </ul>
    </nav>
<?php endif ?>
