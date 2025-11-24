<!DOCTYPE html>
<html>

<head>
    <title>Drug Search</title>
    <style>
        /* Pagination Wrapper */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            padding: 12px 0;
            margin: 0;
        }

        /* Each item */
        .pagination li {
            list-style: none;
        }

        /* Links */
        .pagination a,
        .pagination span {
            display: block;
            padding: 8px 16px;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            color: #0d6efd;
            border: 1px solid #d0d7de;
            background: #ffffff;
            border-radius: 50px;
            /* pill shape */
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
            transition: all 0.25s ease;
        }

        /* Hover */
        .pagination a:hover {
            background: #e7f0ff;
            border-color: #bcd1ff;
            transform: translateY(-2px);
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.12);
        }

        /* Active Page */
        .pagination .active a,
        .pagination .active span {
            background: #0d6efd !important;
            color: white !important;
            border-color: #0d6efd !important;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.18);
            transform: translateY(-2px);
        }

        /* Disabled (optional) */
        .pagination .disabled span,
        .pagination .disabled a {
            background: #f1f1f1;
            color: #999;
            border-color: #ddd;
            box-shadow: none;
            cursor: not-allowed;
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
    <div class="d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>

</body>

</html>