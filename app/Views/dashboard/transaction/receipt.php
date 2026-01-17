<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
/* ================= SCHOOL INFO (EDIT HERE ONLY) ================= */
$schoolName    = 'Jhenaidah Cadet Coaching';
$schoolAddress = 'রেবাংলা সড়ক, কেন্দ্রীয় গোরস্থান সংলগ্ন, ঝিনাইদহ';
$schoolPhone   = '01886007142, 01916487915';

/* ================= MONTH MAP ================= */
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
    size: A4;
    margin: 10mm;
}

body {
    font-family: "Times New Roman", serif;
}

.page {
    width: 210mm;
}



.receipt {
    width: 100%;
    min-height: 85mm;
    background: #fffdeb;
    border: 2px solid #000;
    padding: 1mm;
    font-size: 12px;
}

.copy-label {
    text-align: right;
    font-size: 11px;
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
    margin: 1px 0;
}

.info {
    font-size: 12px;
    line-height: 1.6;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1px;
}

th,
td {
    border: 1px solid #000;
    padding: 5px;
}

th {
    background: #f1f1f1;
}

.footer {
    font-size: 11px;
}

.sign {
    display: flex;
    justify-content: space-between;
    margin-top: 16px;
}

.note {
    border-top: 1px solid #000;
    text-align: center;
    font-size: 10px;
}

.divider {
    border-top: 2px dashed #000;
    margin: 1mm 0;
}

.info {
    display: flex;
    width: 100%;
}

.info>div {
    flex: 1;
    /* equal width */
    padding: 0px 8px;
    box-sizing: border-box;
    white-space: nowrap;
}
</style>

<div class="container-fluid px-4 py-3">
    <div class="page">

        <?php for ($copy = 0; $copy < 2; $copy++): ?>
        <div class="receipt">

            <div class="copy-label">
                <?= $copy === 0 ? 'Student Copy' : 'Institute Copy' ?>
            </div>

            <div class="header">
                <div class="school-name"><?= esc($schoolName) ?></div>
                <div class="school-sub">
                    Address: <?= esc($schoolAddress) ?> |
                    Phone: <?= esc($schoolPhone) ?>
                </div>
                <div class="school-sub"><b>Payment Receipt</b></div>
            </div>

            <div class="hr"></div>

            <div class="info">
                <b>Date:</b> <?= date('d-m-Y') ?>&nbsp;&nbsp;
                <b>Receipt No:</b> <?= esc($transaction_id ?? 'N/A') ?>
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
                    <td align="center"><?= $i + 1 ?></td>
                    <td>
                        <?= esc($f['title']) ?>
                        <?php if (!empty($f['month'])): ?>
                        (<?= esc($f['month']) ?>)
                        <?php endif; ?>
                    </td>
                    <td align="center">
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
                    <td colspan="3" align="center">No fees found</td>
                </tr>
                <?php endif; ?>

                <?php if ($copy === 1): ?>
                <tr>
                    <td colspan="2" align="right"><b>Discount</b></td>
                    <td align="right"><?= number_format($discount ?? 0, 2) ?></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><b>Net Amount</b></td>
                    <td align="right"><b><?= number_format($netAmount ?? 0, 2) ?></b></td>
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

        <?php if ($copy === 0): ?>
        <div class="divider"></div>
        <?php endif; ?>

        <?php endfor; ?>

    </div>
</div>

<?= $this->endSection() ?>