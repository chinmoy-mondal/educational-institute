<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
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
        margin: 0;
        padding: 0;
        font-family: "Times New Roman", serif;
    }

    /* ===== ONE PAGE ===== */
    .page {
        width: 210mm;
        height: 297mm;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* ===== HALF PAGE RECEIPT ===== */
    .receipt {
        width: 190mm;

        /* IMPORTANT: adjusted so padding+border fit half A4 */
        height: 136.5mm;

        padding: 6mm;
        border: 2mm solid #000;
        box-sizing: content-box;

        background: #fffdeb;

        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* remove gap between halves */
    .receipt+.receipt {
        border-top: none;
    }

    /* ===== CONTENT ===== */
    .copy-label {
        text-align: right;
        font-weight: bold;
        font-size: 12px;
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

    /* one-line info */
    .info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 11px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 4px;
    }

    th {
        background: #f1f1f1;
    }

    td:nth-child(2) {
        text-align: left;
    }

    td:nth-child(1),
    td:nth-child(3) {
        text-align: center;
    }

    .footer {
        font-size: 11px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
    }

    .note {
        font-size: 10px;
        text-align: center;
        border-top: 1px solid #000;
        padding-top: 2px;
    }

    /* ===== PRINT FIX ===== */
    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
        }

        /* ONE PAGE ONLY */
        .page {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;

            display: block;
            /* 🔴 NOT FLEX */
            page-break-after: avoid;
        }

        /* HALF PAGE */
        .receipt {
            width: 190mm;
            height: 148.5mm;
            /* EXACT HALF A4 */
            margin: 0 auto;

            padding: 6mm;
            border: 2mm solid #000;
            box-sizing: border-box;

            background: #fffdeb;

            page-break-inside: avoid;
        }

        /* remove gap */
        .receipt+.receipt {
            border-top: none;
        }
    }
</style>

<div class="page">

    <!-- ================= STUDENT COPY ================= -->
    <div class="receipt">

        <div class="copy-label">Student Copy</div>

        <div class="header">
            <div class="school-name"><?= esc($schoolName) ?></div>
            <div class="school-sub">
                <?= esc($schoolAddress) ?> | <?= esc($schoolPhone) ?>
            </div>
            <div class="school-sub"><b>Payment Receipt</b></div>
        </div>

        <div class="hr"></div>

        <div class="info">
            <div><b>Date:</b> <?= date('d-m-Y') ?></div>
            <div><b>Receipt No:</b> <?= esc($transaction_id ?? 'N/A') ?></div>
            <div><b>ID:</b> <?= esc($student['id'] ?? '') ?></div>
            <div><b>Roll:</b> <?= esc($student['roll'] ?? '') ?></div>
        </div>

        <div class="hr"></div>

        <table>
            <tr>
                <th width="8%">SL</th>
                <th>Fee Category</th>
                <th width="22%">Status</th>
            </tr>

            <?php foreach ($fees as $i => $f): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($f['title']) ?> <?= !empty($f['month']) ? "({$f['month']})" : '' ?></td>
                    <td><?= $f['paid'] ? 'Paid' : 'Due' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="footer">
            <b>Received By:</b> <?= esc($receiver['name'] ?? 'N/A') ?>
        </div>

        <div class="sign">
            <span>Office</span>
            <span>Student</span>
        </div>

        <div class="note">All paid amounts are non-refundable.</div>

    </div>

    <!-- ================= INSTITUTE COPY ================= -->
    <div class="receipt">

        <div class="copy-label">Institute Copy</div>

        <div class="header">
            <div class="school-name"><?= esc($schoolName) ?></div>
            <div class="school-sub">
                <?= esc($schoolAddress) ?> | <?= esc($schoolPhone) ?>
            </div>
            <div class="school-sub"><b>Payment Receipt</b></div>
        </div>

        <div class="hr"></div>

        <div class="info">
            <div><b>Date:</b> <?= date('d-m-Y') ?></div>
            <div><b>Receipt No:</b> <?= esc($transaction_id ?? 'N/A') ?></div>
            <div><b>ID:</b> <?= esc($student['id'] ?? '') ?></div>
            <div><b>Roll:</b> <?= esc($student['roll'] ?? '') ?></div>
        </div>

        <div class="hr"></div>

        <table>
            <tr>
                <th width="8%">SL</th>
                <th>Fee Category</th>
                <th width="22%">Amount (৳)</th>
            </tr>

            <?php foreach ($fees as $i => $f): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($f['title']) ?> <?= !empty($f['month']) ? "({$f['month']})" : '' ?></td>
                    <td><?= number_format($f['amount'], 2) ?></td>
                </tr>
            <?php endforeach; ?>

            <tr>
                <td colspan="2" align="right"><b>Discount</b></td>
                <td><?= number_format($discount ?? 0, 2) ?></td>
            </tr>
            <tr>
                <td colspan="2" align="right"><b>Net</b></td>
                <td><b><?= number_format($netAmount ?? 0, 2) ?></b></td>
            </tr>
        </table>

        <div class="footer">
            <b>Received By:</b> <?= esc($receiver['name'] ?? 'N/A') ?>
        </div>

        <div class="sign">
            <span>Office</span>
            <span>Accounts</span>
        </div>

        <div class="note">All paid amounts are non-refundable.</div>

    </div>

</div>

<?= $this->endSection() ?>