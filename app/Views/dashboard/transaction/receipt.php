<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
$schoolName    = 'Jhenaidah Cadet Coaching';
$schoolAddress = 'রেবাংলা সড়ক, কেন্দ্রীয় গোরস্থান সংলগ্ন, ঝিনাইদহ';
$schoolPhone   = '01886007142, 01916487915';

$monthNames = [
    1  => 'January',
    2  => 'February',
    3  => 'March',
    4  => 'April',
    5  => 'May',
    6  => 'June',
    7  => 'July',
    8  => 'August',
    9  => 'September',
    10 => 'October',
    11 => 'November',
    12 => 'December',
];
?>

<style>
    @page {
        size: A4 portrait;
        margin: 0;
    }

    body {
        font-family: "Times New Roman", serif;
        margin: 0;
        padding: 0;
    }

    .page {
        width: 210mm;
        height: 297mm;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .receipt {
        width: 100%;
        height: 25%;
        /* 1/4 of A4 page height */
        background: #fffdeb;
        border: 2px solid #000;
        padding: 5mm;
        box-sizing: border-box;
        font-size: 11px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 2mm;
    }

    .copy-label {
        text-align: right;
        font-size: 10px;
        font-weight: bold;
    }

    .header {
        text-align: center;
    }

    .school-name {
        font-size: 14px;
        font-weight: bold;
        color: #b30000;
    }

    .school-sub {
        font-size: 9px;
    }

    .hr {
        border-top: 1px solid #000;
        margin: 4px 0;
    }

    .info {
        font-size: 11px;
        line-height: 1.4;
        display: flex;
        width: 100%;
        margin-bottom: 2px;
    }

    .info>div {
        flex: 1;
        padding: 0 4px;
        box-sizing: border-box;
        white-space: nowrap;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2px;
        font-size: 10px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 2px;
        text-align: center;
    }

    th {
        background: #f1f1f1;
    }

    .footer {
        font-size: 10px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        margin-top: 4px;
    }

    .note {
        margin-top: 2px;
        border-top: 1px solid #000;
        text-align: center;
        font-size: 9px;
    }

    @media print {

        body,
        .page {
            margin: 0;
            width: 210mm;
            height: 297mm;
        }

        .receipt {
            page-break-inside: avoid;
            height: 25%;
            margin-bottom: 0;
        }
    }
</style>

<div class="container-fluid px-0">
    <div class="page">

        <?php for ($copy = 0; $copy < 2; $copy++): ?>
            <div class="receipt">

                <div class="copy-label">
                    <?= $copy === 0 ? 'Student Copy' : 'Institute Copy' ?>
                </div>

                <div class="header">
                    <div class="school-name"><?= esc($schoolName) ?></div>
                    <div class="school-sub">
                        Address: <?= esc($schoolAddress) ?> | Phone: <?= esc($schoolPhone) ?>
                    </div>
                    <div class="school-sub"><b>Payment Receipt</b></div>
                </div>

                <div class="hr"></div>

                <div class="info">
                    <div><b>Date:</b> <?= date('d-m-Y') ?></div>
                    <div><b>Receipt No:</b> <?= esc($transaction_id ?? 'N/A') ?></div>
                </div>

                <div class="hr"></div>

                <div class="info">
                    <div><b>Student Name:</b> <?= esc($student['student_name'] ?? 'N/A') ?></div>
                    <div><b>Student ID:</b> <?= esc($student['id'] ?? '') ?></div>
                    <div><b>Index No:</b> <?= esc($student['roll'] ?? '') ?></div>
                    <div><b>Section:</b> <?= esc($student['section'] ?? '') ?></div>
                </div>

                <div class="hr"></div>

                <table>
                    <tr>
                        <th width="7%">SL</th>
                        <th>Fee Category</th>
                        <th width="22%">Status / Amount (৳)</th>
                    </tr>

                    <?php if (!empty($fees)): ?>
                        <?php foreach ($fees as $i => $f): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <?= esc($f['title']) ?>
                                    <?php if (!empty($f['month']) && isset($monthNames[(int)$f['month']])): ?>
                                        (<?= $monthNames[(int)$f['month']] ?>)
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($copy === 0): ?>
                                        <?= !empty($f['paid']) ? 'Paid' : 'Due' ?>
                                    <?php else: ?>
                                        <?= number_format($f['amount'], 2) ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No fees found</td>
                        </tr>
                    <?php endif; ?>

                    <?php if ($copy === 1): ?>
                        <tr>
                            <td colspan="2" align="right"><b>Discount</b></td>
                            <td><?= number_format($discount ?? 0, 2) ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><b>Net Amount</b></td>
                            <td><b><?= number_format($netAmount ?? 0, 2) ?></b></td>
                        </tr>
                    <?php endif; ?>
                </table>

                <div class="footer">
                    <b>Payment Mode:</b> Cash / Mobile / Bank<br>
                    <b>Received By:</b> <?= esc($receiver['name'] ?? 'N/A') ?>
                </div>

                <div class="sign">
                    <span>Office Signature</span>
                    <span>Depositor Signature</span>
                </div>

                <div class="note">All paid amounts are non-refundable.</div>

            </div>
        <?php endfor; ?>

    </div>
</div>

<?= $this->endSection() ?>