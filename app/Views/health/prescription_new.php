<!DOCTYPE html>
<html>

<head>
    <title>Drug Search</title>
    <style>
        .pagination .page-link {
            border-radius: 6px !important;
            margin: 0 3px;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
            color: #fff !important;
        }

        .pagination .page-link:hover {
            background-color: #e9ecef;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3 class="mb-3">Drug List</h3>

    <!-- Search Form -->
    <form method="get" class="mb-3">
        <input type="text" name="q" class="form-control"
            placeholder="Search drugs..." value="<?= esc($search) ?>">
        <button class="btn btn-primary mt-2">Search</button>
    </form>

    <!-- Drug Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>SL</th>
                <th>Company</th>
                <th>Drug Type</th>
                <th>Drug Name</th>
                <th>Group</th>
                <th>Price</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>

            <?php if (count($drugs) == 0): ?>
                <tr>
                    <td colspan="7" class="text-center text-danger">No drugs found</td>
                </tr>
            <?php endif; ?>

            <!-- Serial number across pages -->
            <?php
            $page  = $pager->getCurrentPage();      // current page
            $perPage = $pager->getPerPage();        // per-page count
            $i = ($page - 1) * $perPage + 1;         // starting SL number
            ?>

            <?php foreach ($drugs as $d): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= esc($d['company']) ?></td>
                    <td><?= esc($d['drug_type']) ?></td>
                    <td><?= esc($d['drug_name']) ?></td>
                    <td><?= esc($d['group_name']) ?></td>
                    <td><?= esc($d['price']) ?></td>
                    <td><?= esc($d['quantity']) ?> <?= esc($d['unit_type']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-3">
        <?= $pager->links('default', 'bs_full') ?>
    </div>

</body>

</html>