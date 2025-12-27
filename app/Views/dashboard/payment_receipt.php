<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Payment Receipt</title>

    <style>
    @page {
        size: A4;
        margin: 10mm;
    }

    body {
        font-family: "Times New Roman", serif;
        margin: 0;
        padding: 0;
    }

    .page {
        width: 210mm;
        height: 297mm;
    }

    .receipt {
        width: 100%;
        height: 135mm;
        background: #fffdb0;
        border: 1.5px solid #000;
        padding: 8mm;
        font-size: 12px;
        margin-bottom: 6mm;
        box-sizing: border-box;
    }

    .copy-label {
        text-align: right;
        font-size: 11px;
        font-weight: bold;
    }

    .logo-wrap {
        text-align: center;
        margin-bottom: 5px;
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
        margin: 5px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
    }

    th {
        text-align: center;
        background: #f2f2f2;
    }

    .footer {
        font-size: 11px;
        margin-top: 6px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        margin-top: 14px;
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

        <?php for ($copy = 0; $copy < 2; $copy++): ?>

        <div class="receipt">

            <div class="copy-label">
                <?= $copy === 0 ? 'Student Copy' : 'Institute Copy' ?>
            </div>

            <!-- LOGO -->
            <div class="logo-wrap">
                <svg viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="48" fill="#b30000" />
                    <text x="50" y="62" font-size="42" fill="#fff" text-anchor="middle"
                        font-family="Times New Roman">S</text>
                </svg>
            </div>

            <div class="title">YOUR SCHOOL NAME</div>
            <div class="subtitle">Address: __________________ Phone: __________</div>
            <div class="subtitle"><b>Payment Receipt</b></div>

            <div class="hr"></div>

            <b>Date:</b> <?= esc($date ?? date('Y-m-d')) ?>
            &nbsp;&nbsp;
            <b>Receipt No:</b> ___________

            <div class="hr"></div>

            <!-- STUDENT INFO -->
            <b>Student Name:</b> <?= esc($student['student_name'] ?? 'N/A') ?><br>
            <b>Student ID:</b> <?= esc($student['id'] ?? '') ?><br>
            <b>Class:</b> <?= esc($student['class'] ?? '') ?><br>
            <b>Session:</b> <?= esc($student['session'] ?? '') ?>

            <div class="hr"></div>

            <!-- FEES TABLE -->
            <table>
                <tr>
                    <th width="8%">SL</th>
                    <th>Particulars</th>
                    <th width="25%">Amount (৳)</th>
                </tr>

                <?php if (!empty($fees)): ?>
                <?php foreach ($fees as $i => $f): ?>
                <tr>
                    <td align="center"><?= $i + 1 ?></td>
                    <td><?= esc($f['title']) ?> <?= $f['month'] ? '(' . esc($f['month']) . ')' : '' ?></td>
                    <td align="right"><?= number_format($f['amount'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>

                <tr>
                    <td colspan="2" align="right"><b>Discount</b></td>
                    <td align="right"><?= number_format($discount ?? 0, 2) ?></td>
                </tr>

                <tr>
                    <td colspan="2" align="right"><b>Total Paid</b></td>
                    <td align="right"><b><?= number_format($totalAmount ?? 0, 2) ?></b></td>
                </tr>
            </table>

            <!-- FOOTER -->
            <div class="footer">
                <b>Payment Mode:</b> Cash / Mobile / Bank<br>
                <b>Received By:</b> <?= esc($receiver['name'] ?? 'N/A') ?><br>
                <b>Date:</b> <?= esc($date ?? date('Y-m-d')) ?>
            </div>

            <div class="sign">
                <span>Office Signature</span>
                <span>Student Signature</span>
            </div>

            <div class="note">
                All paid amounts are non-refundable.
            </div>

        </div>

        <?php if ($copy === 0): ?>
        <div class="divider"></div>
        <?php endif; ?>

        <?php endfor; ?>

    </div>

</body>

</html>

<?= $this->endSection() ?>