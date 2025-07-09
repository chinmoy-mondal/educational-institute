<?php if ($pager->hasPages()): ?>
    <?php
        $details = $pager->getDetails();
        $current = $details['current'];
        $pageCount = $details['pageCount'];
        $range = 5;

        $start = max(1, $current - $range);
        $end = min($pageCount, $current + $range);
    ?>
    <nav>
        <ul class="pagination justify-content-center">
            <!-- First -->
            <li class="page-item <?= $current == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pager->getFirst() ?>">First</a>
            </li>

            <!-- Previous -->
            <?php if ($pager->hasPrevious()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getPreviousPage() ?>">&laquo;</a>
                </li>
            <?php endif ?>

            <!-- Page numbers -->
            <?php for ($i = $start; $i <= $end; $i++): ?>
                <li class="page-item <?= $i == $current ? 'active' : '' ?>">
                    <a class="page-link" href="<?= $pager->getPageURI($i) ?>"><?= $i ?></a>
                </li>
            <?php endfor ?>

            <!-- Next -->
            <?php if ($pager->hasNext()): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $pager->getNextPage() ?>">&raquo;</a>
                </li>
            <?php endif ?>

            <!-- Last -->
            <li class="page-item <?= $current == $pageCount ? 'disabled' : '' ?>">
                <a class="page-link" href="<?= $pager->getLast() ?>">Last</a>
            </li>
        </ul>
    </nav>
<?php endif ?>
