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

        .btn-pay {
            margin-top: 25px;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="receipt shadow">

        <div class="title">
            📄 Subscription Payment Receipt
        </div>

        <div class="box">

            <div class="row-item">
                <div class="label">Subscription End Date</div>
                <div class="value"><?= esc($subscription) ?></div>
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

        <button class="btn btn-success btn-pay">
            Pay Now (bKash / Nagad)
        </button>

    </div>

</body>

</html>