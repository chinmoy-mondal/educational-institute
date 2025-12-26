<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Payment Receipt</title>
    <style>
    body {
        font-family: "Times New Roman", serif;
        margin: 0;
        padding: 0;
    }

    .page {
        width: 210mm;
        height: 297mm;
        box-sizing: border-box;
    }

    .receipt {
        width: 100%;
        background: #fffdb0;
        border: 1.5px solid #000;
        padding: 8mm;
        font-size: 12px;
        margin-bottom: 10mm;
    }

    .copy-label {
        text-align: right;
        font-weight: bold;
        font-size: 11px;
    }

    .logo-wrap {
        text-align: center;
        margin-bottom: 4px;
    }

    .logo-wrap svg {
        height: 45px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        color: #b30000;
        font-size: 16px;
    }

    .subtitle {
        text-align: center;
        font-size: 11px;
    }

    .hr {
        border-top: 1px solid #000;
        margin: 4px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 3px;
    }

    th {
        text-align: center;
    }

    .footer {
        font-size: 11px;
        margin-top: 4px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        margin-top: 12px;
    }

    .note {
        border-top: 1px solid #000;
        margin-top: 6px;
        text-align: center;
        font-size: 10px;
    }

    .divider {
        border-top: 2px dashed #000;
        margin: 6mm 0;
    }
    </style>
</head>

<body>

    <div class="page">

        <?php foreach (['Student Copy', 'Institute Copy'] as $copy): ?>
        <div class="receipt">
            <div class="copy-label"><?= $copy ?></div>
            <div class="logo-wrap">
                <svg viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="48" fill="#b30000" /><text x="50" y="60" font-size="42" fill="#fff"
                        text-anchor="middle" font-family="Times New Roman">S</text>
                </svg>
            </div>
            <div class="subtitle">Receipt</div>
            <div class="title">YOUR SCHOOL NAME</div>
            <div class="subtitle">Address: __________________ Phone: __________</div>
            <div class="hr"></div>
            <b>Receipt No:</b> <?= $transactions[0]['transaction_id'] ?? '---' ?> &nbsp;&nbsp;
            <b>Date:</b> <?= date('Y-m-d') ?>
            <div class="hr"></div>
            <b>Name of Student:</b> <?= esc($student['student_name']) ?><br>
            <b>Class / Course:</b> <?= esc($student['class']) ?><br>
            <b>Session:</b> ____________ &nbsp;&nbsp;
            <b>Date of Payment:</b> <?= date('Y-m-d') ?>
            <div class="hr"></div>

            <table>
                <tr>
                    <th>Sl</th>
                    <th>Particulars</th>
                    <th>Amount (৳)</th>
                </tr>
                <?php $total = 0;
                    foreach ($transactions as $i => $txn):
                        $paid = $txn['amount'] - ($txn['discount'] ?? 0);
                        $total += $paid;
                    ?>
                <tr>
                    <td align="center"><?= $i + 1 ?></td>
                    <td><?= esc($txn['purpose']) ?> (Discount: <?= esc($txn['discount']) ?>)</td>
                    <td align="right"><?= number_format($paid, 2) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="2" align="right"><b>Total</b></td>
                    <td align="right"><b><?= number_format($total, 2) ?></b></td>
                </tr>
            </table>

            <div class="footer">
                <b>Paid By:</b> Cash / Mobile / Bank<br>
                <b>Balance (if any):</b> ____________
            </div>
            <div class="sign">
                <span>Signature of Office</span>
                <span>Signature of Student</span>
            </div>
            <div class="note">
                All above mentioned amount once paid are non-refundable.
            </div>
        </div>
        <div class="divider"></div>
        <?php endforeach; ?>

    </div>
</body>

</html>