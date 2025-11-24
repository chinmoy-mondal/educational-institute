<!DOCTYPE html>
<html>
<head>
    <title>Drug Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="p-4">

    <h3 class="mb-3">Drug List</h3>

    <!-- Search Form -->
    <form method="get" class="mb-3">
        <input type="text" name="q" class="form-control" placeholder="Search drugs..."
               value="<?= esc($search) ?>">
        <button class="btn btn-primary mt-2">Search</button>
    </form>

    <!-- Drug Table -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
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
                    <td colspan="6" class="text-center text-danger">No drugs found</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($drugs as $d): ?>
                <tr>
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

</body>
</html>