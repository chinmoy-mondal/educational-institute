<!DOCTYPE html>
<html>

<head>
    <title>Digital Prescription</title>
    <style>
        body {
            background: #f2f6fc;
            font-family: "Segoe UI", sans-serif;
            padding: 20px;
        }

        .prescription-box {
            margin: auto;
            background: white;
            width: 900px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header .name {
            font-size: 28px;
            font-weight: 700;
        }

        .header .degree {
            font-size: 14px;
        }

        .section-title {
            font-weight: 600;
            margin-top: 20px;
            margin-bottom: 8px;
            border-left: 4px solid #007bff;
            padding-left: 8px;
        }

        .rx-symbol {
            font-size: 45px;
            font-weight: bold;
            color: #007bff;
        }

        .divider {
            border-top: 3px dashed #999;
            margin: 25px 0;
        }

        .drug-box {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #dcdcdc;
            background: #fafafa;
            margin-bottom: 12px;
        }

        .footer-note {
            font-size: 13px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="prescription-box">

        <div class="header">
            <div class="name">Dr. John Doe</div>
            <div class="degree">MBBS, FCPS (Medicine)</div>
            <div class="degree">Consultant - General Physician</div>
            <small>Reg No: 123456</small>
        </div>

        <!-- Patient Info -->
        <div>
            <label>Patient Name</label>
            <input type="text" style="width: 250px; padding: 6px;">

            <label style="margin-left: 20px;">Age</label>
            <input type="text" style="width: 80px; padding: 6px;">

            <label style="margin-left: 20px;">Date</label>
            <input type="date" style="padding: 6px;">
        </div>

        <div class="section-title">Chief Complaint (C/C)</div>
        <textarea rows="2" style="width: 100%; padding: 8px;"></textarea>

        <div class="section-title">On Examination (P/E)</div>
        <textarea rows="2" style="width: 100%; padding: 8px;"></textarea>

        <div class="section-title">Advice</div>
        <textarea rows="2" style="width: 100%; padding: 8px;"></textarea>

        <div class="divider"></div>

        <!-- RX -->
        <div style="display: flex; align-items: center; margin-bottom: 15px;">
            <div class="rx-symbol">℞</div>
            <h3 style="margin-left: 10px;">Prescription</h3>
        </div>

        <div id="drug-list">

            <div class="drug-box">
                <label>Medicine</label><br>
                <select style="width: 60%; padding: 7px;">
                    <option value="">Select Drug</option>
                    <?php foreach ($drugs as $d): ?>
                        <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                    <?php endforeach; ?>
                </select>

                <br><br>

                <label>Dose</label>
                <input type="text" placeholder="1+0+1" style="padding: 7px; width: 120px;">

                <label style="margin-left: 20px;">Duration</label>
                <input type="text" placeholder="5 days" style="padding: 7px; width: 120px;">
            </div>

        </div>

        <button onclick="addDrug()" style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
            + Add Drug
        </button>

        <div class="footer-note">
            ** This is a computer-generated prescription. Signature not required. **
        </div>

    </div>

    <script>
        function addDrug() {
            let html = `
        <div class="drug-box">
            <label>Medicine</label><br>
            <select style="width: 60%; padding: 7px;">
                <option value="">Select Drug</option>
                <?php foreach ($drugs as $d): ?>
                    <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <br><br>

            <label>Dose</label>
            <input type="text" placeholder="1+0+1" style="padding: 7px; width: 120px;">

            <label style="margin-left: 20px;">Duration</label>
            <input type="text" placeholder="5 days" style="padding: 7px; width: 120px;">
        </div>
    `;
            document.getElementById('drug-list').insertAdjacentHTML('beforeend', html);
        }
    </script>

</body>

</html>