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
            width: 1000px;
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

        .columns {
            display: flex;
            gap: 30px;
        }

        .left-column {
            flex: 1;
        }

        .right-column {
            flex: 1;
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
        }

        .section-title {
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 5px;
            border-left: 4px solid #007bff;
            padding-left: 8px;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 7px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .rx-symbol {
            font-size: 50px;
            font-weight: bold;
            color: #007bff;
            text-align: center;
        }

        .drug-box {
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #dcdcdc;
            background: #fafafa;
            margin-bottom: 10px;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
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

        <div class="columns">
            <!-- LEFT SIDE: Patient info + CC + PE + Advice -->
            <div class="left-column">
                <div>
                    <label>Patient Name</label>
                    <input type="text">

                    <label>Age</label>
                    <input type="text">

                    <label>Date</label>
                    <input type="date">
                </div>

                <div class="section-title">Chief Complaint (C/C)</div>
                <textarea rows="3"></textarea>

                <div class="section-title">On Examination (P/E)</div>
                <textarea rows="3"></textarea>

                <div class="section-title">Advice</div>
                <textarea rows="3"></textarea>
            </div>

            <!-- RIGHT SIDE: RX / Medicines -->
            <div class="right-column">
                <div class="rx-symbol">℞</div>
                <h3 style="text-align:center; margin-top:5px;">Prescription</h3>

                <div id="drug-list">
                    <div class="drug-box">
                        <label>Medicine</label>
                        <select>
                            <option value="">Select Drug</option>
                            <?php foreach ($drugs as $d): ?>
                                <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                            <?php endforeach; ?>
                        </select>

                        <label>Dose</label>
                        <input type="text" placeholder="1+0+1">

                        <label>Duration</label>
                        <input type="text" placeholder="5 days">
                    </div>
                </div>

                <button onclick="addDrug()">+ Add Drug</button>
            </div>
        </div>

        <div class="footer-note">
            ** This is a computer-generated prescription. Signature not required. **
        </div>

    </div>

    <script>
        function addDrug() {
            let html = `
        <div class="drug-box">
            <label>Medicine</label>
            <select>
                <option value="">Select Drug</option>
                <?php foreach ($drugs as $d): ?>
                    <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <label>Dose</label>
            <input type="text" placeholder="1+0+1">

            <label>Duration</label>
            <input type="text" placeholder="5 days">
        </div>`;
            document.getElementById('drug-list').insertAdjacentHTML('beforeend', html);
        }
    </script>

</body>

</html>