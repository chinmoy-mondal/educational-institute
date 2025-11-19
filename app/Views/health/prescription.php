<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Digital Prescription</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e8f5e9;
            font-family: "SolaimanLipi", sans-serif;
            padding: 20px;
        }

        .pad-container {
            width: 850px;
            margin: auto;
            background: white;
            border: 1px solid #dcdcdc;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }

        /* Header style */
        .pad-header {
            background: #f3eacb;
            padding: 20px;
            border-bottom: 3px solid #c5a66a;
            text-align: center;
        }

        .pad-header h2 {
            color: #b30000;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .pad-header h4 {
            font-size: 18px;
            font-weight: bold;
            color: #b30000;
        }

        .pad-header small {
            font-size: 13px;
            color: #444;
        }

        /* Columns */
        .left-box {
            background: linear-gradient(to bottom, #dfffe4, #c3f2cd);
            min-height: 600px;
            padding: 15px;
            border-right: 2px solid #ddd;
        }

        .right-box {
            background: white;
            min-height: 600px;
            padding: 15px;
            background-image: url('https://i.imgur.com/Zq8YQbK.png');
            /* Stethoscope watermark */
            background-size: 250px;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.95;
        }

        .rx {
            font-size: 48px;
            font-weight: 900;
            color: #cc0000;
            margin-bottom: 10px;
        }

        .footer {
            background: #b7e7bc;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            border-top: 2px solid #9ccd9c;
        }

        .drug-box {
            padding: 10px;
            background: #fafafa;
            border-left: 4px solid green;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>

    <div class="pad-container">

        <!-- HEADER -->
        <div class="pad-header">
            <h2>ডাঃ মোছাঃ মিনা</h2>
            <small>এম বি বি এস (ঢাকা মেডিকেল কলেজ)</small><br>
            <small>এম সি পি এস (মেডিসিন)</small><br>
            <small>মেডিসিন, ডায়াবেটিস, থাইরয়েড, কার্ডিওলজি বিশেষজ্ঞ</small><br>
            <small>রংপুর হাসপাতাল, বি এস এস রোড</small>

            <hr>

            <h4>DR. MST. RIMA</h4>
            <small>MBBS (DMC), FCPS (Medicine)</small><br>
            <small>Consultant – Internal Medicine, Endocrinology</small><br>
            <small>Reg No: 123456</small>
        </div>

        <!-- BODY -->
        <div class="row g-0">

            <!-- LEFT COLUMN -->
            <div class="col-4 left-box">
                <label class="fw-bold">নাম</label>
                <input type="text" class="form-control mb-2">

                <label class="fw-bold">বয়স</label>
                <input type="text" class="form-control mb-2">

                <label class="fw-bold">তারিখ</label>
                <input type="date" class="form-control mb-3">

                <label class="fw-bold">C/C (Chief Complaint)</label>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <label class="fw-bold">P/E (On Examination)</label>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <label class="fw-bold">Advice</label>
                <textarea rows="4" class="form-control mb-3"></textarea>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-8 right-box">

                <div class="rx">℞</div>

                <div id="drug-list">

                    <div class="drug-box">
                        <label class="fw-bold">Medicine</label>
                        <select class="form-select mb-2">
                            <option value="">Select Drug</option>
                            <?php foreach ($drugs as $d): ?>
                                <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                            <?php endforeach; ?>
                        </select>

                        <label class="fw-bold">Dose</label>
                        <input type="text" class="form-control mb-2" placeholder="1+0+1">

                        <label class="fw-bold">Duration</label>
                        <input type="text" class="form-control mb-2" placeholder="5 days">
                    </div>

                </div>

                <button onclick="addDrug()" class="btn btn-success mt-1">+ Add More Medicine</button>

            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            তারিখ/ফলোআপঃ _______________________
        </div>

    </div>

    <script>
        function addDrug() {
            let html = `
            <div class="drug-box">
                <label class="fw-bold">Medicine</label>
                <select class="form-select mb-2">
                    <option value="">Select Drug</option>
                    <?php foreach ($drugs as $d): ?>
                        <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                    <?php endforeach; ?>
                </select>

                <label class="fw-bold">Dose</label>
                <input type="text" class="form-control mb-2" placeholder="1+0+1">

                <label class="fw-bold">Duration</label>
                <input type="text" class="form-control mb-2" placeholder="5 days">
            </div>
            `;
            document.getElementById('drug-list').insertAdjacentHTML('beforeend', html);
        }
    </script>

</body>

</html>