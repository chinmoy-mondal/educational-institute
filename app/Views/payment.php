<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f2f4f7;
        }

        .receipt {
            max-width: 600px;
            margin: 60px auto;
            padding: 30px;
            border-radius: 12px;
            background: #fff;
        }

        .title {
            text-align: center;
            font-size: 26px;
            font-weight: bold;
            color: #dc3545;
        }

        .box {
            margin-top: 20px;
        }

        .row-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .label {
            font-weight: 600;
        }

        .value {
            color: #333;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: green;
        }

        .status {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }

        .expired {
            color: red;
        }

        .active {
            color: green;
        }

        .btn-pay {
            margin-top: 25px;
            width: 100%;
        }

        .contact {
            margin-top: 20px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <?php
    $today = new DateTime();
    $start = new DateTime($start_date);
    $end   = new DateTime($end_date);

    // difference
    $diff = $today->diff($end);
    $days_over = ($today > $end) ? $diff->days : 0;
    $is_expired = $today > $end;
    ?>

    <div class="receipt shadow">

        <div class="title">
            📄 Subscription Payment Receipt
        </div>

        <div class="box">

            <div class="row-item">
                <div class="label">Subscription Start</div>
                <div class="value"><?= date('d-m-Y', strtotime($start_date)) ?></div>
            </div>

            <div class="row-item">
                <div class="label">Subscription End</div>
                <div class="value"><?= date('d-m-Y', strtotime($end_date)) ?></div>
            </div>

            <div class="row-item">
                <div class="label">Domain Charge</div>
                <div class="value">৳ <?= esc($domain) ?></div>
            </div>

            <div class="row-item">
                <div class="label">Due Amount</div>
                <div class="value">৳ <?= esc($due) ?></div>
            </div>

            <div class="row-item total">
                <div>Total Payable</div>
                <div>৳ <?= esc($domain + $due) ?></div>
            </div>

        </div>

        <!-- STATUS -->
        <div class="status <?= $is_expired ? 'expired' : 'active' ?>">
            <?php if ($is_expired): ?>
                ⚠️ Expired by <?= $days_over ?> day(s)
            <?php else: ?>
                ✔ Active Subscription
            <?php endif; ?>
        </div>

        <div class="contact">
            📞 Contact: 01920232269
        </div>

        <button class="btn btn-success btn-pay">
            Pay Now (bKash / Nagad)
        </button>

    </div>

</body>

</html>