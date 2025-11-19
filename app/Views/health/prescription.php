<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription Pad</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e8f5e9;
            font-family: "SolaimanLipi", sans-serif;
            padding: 20px;
        }

        .pad-container {
            width: 900px;
            margin: auto;
            background: white;
            border: 1px solid #c9c9c9;
            box-shadow: 0 0 14px rgba(0, 0, 0, 0.12);
        }

        /* HEADER */
        .pad-header {
            background: #f6ebcd;
            padding: 20px 30px;
            border-bottom: 3px solid #c5a66a;
        }

        .header-left {
            width: 50%;
            float: left;
        }

        .header-right {
            width: 50%;
            float: right;
            text-align: right;
        }

        .header-left h2,
        .header-right h2 {
            font-weight: bold;
            color: #b30000;
            margin-bottom: 5px;
        }

        /* PATIENT NAV BAR */
        .patient-nav {
            background: #def7e5;
            padding: 10px 20px;
            border-bottom: 2px solid #b5deb8;
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .patient-nav label {
            font-weight: bold;
            margin-right: 5px;
        }

        /* BODY */
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
            background-size: 220px;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.98;
        }

        .rx {
            font-size: 48px;
            font-weight: 900;
            color: #cc0000;
            margin-bottom: 10px;
        }

        /* DRUG CONTAINER */
        .drug-box {
            padding: 10px;
            background: #f9f9f9;
            border-left: 4px solid green;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .footer {
            background: #b7e7bc;
            padding: 10px;
            text-align: center;
            border-top: 2px solid #9ccd9c;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>

    <div class="pad-container">

        <!-- HEADER -->
        <div class="pad-header clearfix">
            <!-- LEFT -->
            <div class="header-left">
                <h2>ডাঃ মোছাঃ মিনা</h2>
                <small>এম বি বি এস (ঢাকা মেডিকেল কলেজ)</small><br>
                <small>এম সি পি এস (মেডিসিন)</small><br>
                <small>মেডিসিন, ডায়াবেটিস, কার্ডিওলজি বিশেষজ্ঞ</small><br>
                <small>রংপুর হাসপাতাল, বি এস এস রোড</small>
            </div>

            <!-- RIGHT -->
            <div class="header-right">
                <h2>DR. MST. RIMA</h2>
                <small>MBBS (DMC), FCPS (Medicine)</small><br>
                <small>Consultant – Internal Medicine</small><br>
                <small>Reg No: 123456</small>
            </div>
        </div>

        <!-- PATIENT NAV BAR -->
        <div class="patient-nav">
            <div>
                <label>নাম:</label>
                <input type="text" class="form-control form-control-sm" style="width:180px;">
            </div>

            <div>
                <label>বয়স:</label>
                <input type="text" class="form-control form-control-sm" style="width:100px;">
            </div>

            <div>
                <label>তারিখ:</label>
                <input type="date" class="form-control form-control-sm" style="width:150px;">
            </div>
        </div>

        <!-- BODY -->
        <div class="row g-0">

            <!-- LEFT COLUMN -->
            <div class="col-4 left-box">
                <label class="fw-bold">C/C</label>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <label class="fw-bold">P/E</label>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <label class="fw-bold">Advice</label>
                <textarea rows="4" class="form-control mb-3"></textarea>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-8 right-box">
                <div class="rx">℞</div>

                <!-- SEARCH BOX -->
                <input type="text" id="searchDrug" class="form-control mb-3" placeholder="Search medicine...">

                <div id="drug-list">
                    <!-- Default drug row -->
                    <div class="drug-box">
                        <label class="fw-bold">Medicine</label>
                        <select class="form-select drug-select mb-2">
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

                <button onclick="addDrug()" class="btn btn-success mt-1">+ Add Another Medicine</button>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            Follow-up date: ______________________
        </div>

    </div>


    <!-- JS SCRIPT -->
    <script>
        // Add new medicine box
        function addDrug() {
            let html = `
        <div class="drug-box">
            <label class="fw-bold">Medicine</label>
            <select class="form-select drug-select mb-2">
                <option value="">Select Drug</option>
                <?php foreach ($drugs as $d): ?>
                    <option><?= $d['drug_name'] ?> (<?= $d['quantity'] ?> <?= $d['unit_type'] ?>)</option>
                <?php endforeach; ?>
            </select>

            <label class="fw-bold">Dose</label>
            <input type="text" class="form-control mb-2" placeholder="1+0+1">

            <label class="fw-bold">Duration</label>
            <input type="text" class="form-control mb-2" placeholder="5 days">
        </div>`;
            document.getElementById('drug-list').insertAdjacentHTML('beforeend', html);
        }

        // Search drug (live)
        document.getElementById('searchDrug').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let selects = document.querySelectorAll('.drug-select');

            selects.forEach(function(sel) {
                for (let i = 0; i < sel.options.length; i++) {
                    let txt = sel.options[i].text.toLowerCase();
                    sel.options[i].style.display = txt.includes(filter) ? "" : "none";
                }
            });
        });
    </script>

</body>

</html>