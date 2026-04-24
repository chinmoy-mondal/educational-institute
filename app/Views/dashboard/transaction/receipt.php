<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<?php
/* ================= SCHOOL INFO ================= */
$schoolName    = 'Jhenaidah Cadet Coaching';
$schoolAddress = 'শের এ বাংলা সড়ক, কেন্দ্রীয় গোরস্থান সংলগ্ন, ঝিনাইদহ';
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

/* ================= RECEIPT TYPE ================= */
$receiptNo = $transaction_id ?? '';

$isSalary = strpos($receiptNo, 'SAL-') === 0;
$isCost   = strpos($receiptNo, 'CST-') === 0;
$isStudent = strpos($receiptNo, 'TX-') === 0;

$type = 'Payment Receipt';

if ($isSalary) {
    $type = 'Salary Memo';
} elseif ($isCost) {
    $type = 'Cost Memo';
} elseif ($isStudent) {
    $type = 'Student Receipt';
}
?>

<style>
/* ================= PAGE SETUP ================= */
@page {
    size: A4;
    margin: 0;
}

/* ================= BODY ================= */
body {
    font-family: "Times New Roman", serif;
    margin: 0;
    padding: 0;
}

/* ================= PAGE CONTAINER ================= */
.page {
    width: 210mm;
}

/* ================= MEMO BOX (SCREEN + PRINT BASE) ================= */
.receipt {
    width: 100%;
    height: 148.5mm;
    /* HALF A4 PAGE */
    background: #fffdeb;
    border: 2px solid #000;
    padding: 2mm;
    font-size: 12px;
    box-sizing: border-box;

    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    overflow: hidden;
}

/* ================= HEADER ================= */
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

/* ================= LINE ================= */
.hr {
    border-top: 1px solid #000;
    margin: 2px 0;
}

/* ================= INFO SECTION ================= */
.info {
    font-size: 12px;
    line-height: 1.6;
    display: flex;
    width: 100%;
}

.info>div {
    flex: 1;
    padding: 0px 8px;
    white-space: nowrap;
}

/* ================= TABLE ================= */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 2px;
}

th,
td {
    border: 1px solid #000;
    padding: 5px;
}

th {
    background: #f1f1f1;
}

/* ================= FOOTER ================= */
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

/* ================= DIVIDER ================= */
.divider {
    border-top: 2px dashed #000;
    margin: 2mm 0;
}

/* ================= PRINT MODE ================= */
@media print {

    body {
        margin: 0;
        padding: 0;
    }

    .container-fluid {
        padding: 0;
    }

    .page {}

    /* 🔥 MAIN FIX: HALF A4 MEMO */
    .receipt {
        width: 100%;
        height: 77.5mm;
        /* EXACT HALF A4 */
        overflow: hidden;

        border: 2px solid #000;
        background: #fff;
        page-break-inside: avoid;

        padding: 2mm;
        box-sizing: border-box;
    }

    .divider,
    .no-print {
        display: none !important;
    }

    table,
    th,
    td {
        border: 1px solid #000;
        -webkit-print-color-adjust: exact;
    }

    th {
        background: #f1f1f1;
    }
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

                <div class="school-sub">
                    <b><?= esc($type) ?></b>
                </div>
            </div>

            <div class="hr"></div>

            <div class="info">
                <b>Date:</b> <?= date('d-m-Y') ?>&nbsp;&nbsp;
                <b>Receipt No:</b> <?= esc($receiptNo ?: 'N/A') ?>
            </div>

            <div class="hr"></div>

            <!-- ================= USER INFO ================= -->
            <div class="info">

                <?php if ($isStudent): ?>
                <div><b>Student Name:</b> <?= esc($student['student_name'] ?? 'N/A') ?></div>
                <div><b>Student ID:</b> <?= esc($student['id'] ?? '') ?></div>
                <div><b>Index No:</b> <?= esc($student['roll'] ?? '') ?></div>
                <div><b>Section:</b> <?= esc($student['section'] ?? '') ?></div>

                <?php else: ?>
                <div><b>Sender Name:</b> <?= esc($receiver['name'] ?? 'N/A') ?></div>
                <div><b>Type:</b> <?= $isSalary ? 'Salary Payment' : 'Cost Payment' ?></div>
                <div><b>Reference:</b> <?= esc($receiptNo) ?></div>
                <div><b>Status:</b> Processed</div>
                <?php endif; ?>

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

            <!-- ================= SIGNATURE ================= -->
            <div class="sign">
                <span>Office Signature</span>
                <span>
                    <?= ($isSalary || $isCost) ? 'Receiver Signature' : 'Depositor Signature' ?>
                </span>
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