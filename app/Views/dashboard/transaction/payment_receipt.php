<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

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
    }

    .receipt {
        width: 100%;
        min-height: 130mm;
        background: #fffdeb;
        border: 2px solid #000;
        padding: 8mm;
        font-size: 12px;
        box-sizing: border-box;
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
        font-size: 17px;
        font-weight: bold;
        color: #b30000;
    }

    .school-sub {
        font-size: 11px;
    }

    .hr {
        border-top: 1px solid #000;
        margin: 6px 0;
    }

    .info {
        font-size: 12px;
        line-height: 1.6;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 6px;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 5px;
    }

    th {
        background: #f1f1f1;
        text-align: center;
    }

    .footer {
        margin-top: 6px;
        font-size: 11px;
    }

    .sign {
        display: flex;
        justify-content: space-between;
        margin-top: 16px;
    }

    .note {
        margin-top: 6px;
        border-top: 1px solid #000;
        text-align: center;
        font-size: 10px;
    }

    .divider {
        border-top: 2px dashed #000;
        margin: 8mm 0;
    }

    /* ✅ PRINT VIEW FIX */
    @media print {

        /* Remove AdminLTE padding/margin */
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
        }

        /* Make page full width */
        .page {
            width: 100% !important;
            margin: 0 !important;
        }

        /* Receipt full width with 10px margin */
        .receipt {
            width: calc(100% - 20px) !important;
            margin: 0 10px !important;
        }

        .divider {
            width: calc(100% - 20px);
            margin: 8mm 10px;
        }
    }
</style>

<!-- AdminLTE spacing (screen only) -->
<div class="container-fluid px-4 py-3">

    <div class="page">

        <?php for ($copy = 0; $copy < 2; $copy++): ?>

            <div class="receipt">

                <div class="copy-label">
                    <?= $copy === 0 ? 'Student Copy' : 'Institute Copy' ?>
                </div>

                <div class="header">
                    <div class="school-name">YOUR SCHOOL NAME</div>
                    <div class="school-sub">Address: __________ | Phone: __________</div>
                    <div class="school-sub"><b>Payment Receipt</b></div>
                </div>

                <div class="hr"></div>

                <div class="info">
                    <b>Date:</b> <?= esc($date ?? date('Y-m-d')) ?>
                    &nbsp;&nbsp;
                    <b>Receipt No:</b> ___________
                </div>

                <div class="hr"></div>

                <div class="info">
                    <b>Student Name:</b> <?= esc($student['student_name'] ?? 'N/A') ?><br>
                    <b>Student ID:</b> <?= esc($student['id'] ?? '') ?><br>
                    <b>Class:</b> <?= esc($student['class'] ?? '') ?><br>
                    <b>section:</b> <?= esc($student['section'] ?? '') ?>
                </div>

                <div class="hr"></div>

                <table>
                    <tr>
                        <th width="7%">SL</th>
                        <th>Fee Category</th>
                        <th width="22%">Amount (৳)</th>
                    </tr>

                    <?php if (!empty($fees)): ?>
                        <?php foreach ($fees as $i => $f): ?>
                            <tr>
                                <td align="center"><?= $i + 1 ?></td>
                                <td>
                                    <?= esc($f['title']) ?>
                                    <?= !empty($f['month']) ? ' (' . esc($f['month']) . ')' : '' ?>
                                </td>
                                <td align="right"><?= number_format($f['amount'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" align="center">No fees found</td>
                        </tr>
                    <?php endif; ?>

                    <tr>
                        <td colspan="2" align="right"><b>Discount</b></td>
                        <td align="right"><?= number_format($discount ?? 0, 2) ?></td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right"><b>Total Paid</b></td>
                        <td align="right">
                            <b><?= number_format($totalAmount ?? 0, 2) ?></b>
                        </td>
                    </tr>
                </table>

                <div class="footer">
                    <b>Payment Mode:</b> Cash / Mobile / Bank<br>
                    <b>Received By:</b> <?= esc($receiver['name'] ?? 'N/A') ?>
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
</div>

<?= $this->endSection() ?>