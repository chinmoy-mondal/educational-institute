<!DOCTYPE html>
<html>

<head>
    <title>Digital Prescription</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f2f6fc;
            font-family: "Segoe UI", sans-serif;
        }

        .prescription-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .doctor-panel {
            border-right: 2px solid #e7e7e7;
        }

        .doctor-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .doctor-degree {
            font-size: 14px;
            color: #666;
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

    <div class="container mt-4">
        <div class="prescription-box">

            <div class="row">
                <!-- Left Doctor Info Panel -->
                <div class="col-md-4 doctor-panel">
                    <div class="doctor-name">Dr. John Doe</div>
                    <div class="doctor-degree">MBBS, FCPS (Medicine)</div>
                    <div class="doctor-degree">Consultant - General Physician</div>
                    <div class="doctor-degree">Reg No: 123456</div>

                    <hr>

                    <p><strong>Chamber:</strong><br>
                        City Medical Center<br>
                        Road No. 12, Dhanmondi, Dhaka</p>

                    <p><strong>Phone:</strong> 01700-000000</p>
                </div>

                <!-- Right Side Prescription Form -->
                <div class="col-md-8">

                    <!-- Patient Info -->
                    <div class="row mb-3">
                        <div class="col-md-5">
                            <label>Patient Name</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label>Age</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Date</label>
                            <input type="date" class="form-control">
                        </div>
                    </div>

                    <div class="section-title">Chief Complaint (C/C)</div>
                    <textarea class="form-control" rows="2"></textarea>

                    <div class="section-title">On Examination (P/E)</div>
                    <textarea class="form-control" rows="2"></textarea>

                    <div class="section-title">Advice</div>
                    <textarea class="form-control" rows="2"></textarea>

                    <div class="divider"></div>

                    <!-- Rx Section -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="rx-symbol">℞</div>
                        <h4 class="ms-2">Prescription</h4>
                    </div>

                    <div id="drug-list">

                        <div class="drug-box row">
                            <div class="col-md-6">
                                <label>Medicine</label>
                                <select class="form-control">
                                    <option value="">Select Drug</option>
                                    <?php foreach ($drugs as $d): ?>
                                        <option>
                                            <?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-3">
                                <label>Dose</label>
                                <input type="text" class="form-control" placeholder="1+0+1">
                            </div>

                            <div class="col-md-3">
                                <label>Duration</label>
                                <input type="text" class="form-control" placeholder="5 days">
                            </div>
                        </div>

                    </div>

                    <button class="btn btn-primary mt-2" onclick="addDrug()">+ Add Another</button>

                    <div class="footer-note">
                        ** This is a computer-generated prescription. Signature not required. **
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        function addDrug() {
            let html = `
        <div class="drug-box row">
            <div class="col-md-6">
                <label>Medicine</label>
                <select class="form-control">
                    <option value="">Select Drug</option>
                    <?php foreach ($drugs as $d): ?>
                        <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <label>Dose</label>
                <input type="text" class="form-control" placeholder="1+0+1">
            </div>

            <div class="col-md-3">
                <label>Duration</label>
                <input type="text" class="form-control" placeholder="5 days">
            </div>
        </div>
    `;
            document.getElementById('drug-list').insertAdjacentHTML('beforeend', html);
        }
    </script>

</body>

</html>