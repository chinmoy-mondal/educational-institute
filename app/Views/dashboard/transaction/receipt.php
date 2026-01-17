<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
/* ================= SCHOOL INFO ================= */
$schoolName    = 'Jhenaidah Cadet Coaching';
$schoolAddress = 'রেবাংলা সড়ক, কেন্দ্রীয় গোরস্থান সংলগ্ন, ঝিনাইদহ';
$schoolPhone   = '01886007142, 01916487915';
?>

<style>
    @page {
        size: A4;
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
        /* full A4 height */
        display: flex;
        flex-direction: column;
        align-items: center;
        /* center horizontally */
        justify-content: flex-start;
        padding: 0;
        box-sizing: border-box;
    }

    .receipt {
        width: 95%;
        /* horizontally centered */
        height: 48%;
        /* half of A4 minus spacing */
        background: #fffdeb;
        border: 2px solid #000;
        padding: 8mm;
        box-sizing: border-box;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin-bottom: 4%;
        /* small spacing between receipts */
    }

    .copy-label {
        text-align: right;
        font-size: 12px;
        font-weight: bold;
    }

    .header {
        text-align: center;
    }

    .school-name {
        font-size: 18px;
        font-weight: bold;
        color: #b30000;
    }

    .school-sub {
        font-size: 11px;
    }

    .hr {
        border-top: 1px solid #000;
        margin: 4px 0;
    }

    .info {
        display: flex;
        flex-wrap: wrap;
        font-size: 12px;
        line-height: 1.5;
        margin-bottom: 4px;
    }

    .info>div {
        flex: 1 1 50%;
        padding: 0 4px;
        white-space: normal;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
        margin-top: 4px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 3px 5px;
    }

    th {
        background: #f1f1f1;
        text-align: center;
    }

    td:nth-child(2) {
        text-align: left;
        /* Fee Category left-aligned */
    }

    td:nth-child(1),
    td:nth-child(3) {
        text-align: center;
        /* SL and Amount/Status center-aligned */
    }

    .footer {
        font-size: 11px;
        margin-top: 4px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        margin-top: 6px;
        font-size: 11px;
    }

    .note {
        text-align: center;
        font-size: 10px;
        margin-top: 4px;
        border-top: 1px solid #000;
        padding-top: 2px;
        word-wrap: break-word;
    }

    @media print {

        body,
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0;
        }

        .receipt {
            height: 43%;
            width: 100%;
            margin-bottom: 1%;
        }
    }
</style>

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
                                <?= !empty($f['month']) ? "({$f['month']})" : '' ?>
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

<?= $this->endSection() ?>