<!DOCTYPE html>
<html>

<head>
    <title>Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f7f7;
        }

        .prescription-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        .small-text {
            font-size: 12px;
            color: #555;
        }

        .rx-box {
            background: #f0f8ff;
            padding: 15px;
            border-radius: 10px;
            min-height: 420px;
        }

        .left-box {
            background: #fefefe;
            padding: 15px;
            border-radius: 10px;
            min-height: 420px;
        }

        .drug-item {
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }

        .line-input {
            margin-bottom: 5px;
        }

        @media print {

            input,
            select,
            button {
                display: none !important;
            }

            .dose-text,
            .duration-text,
            .rule-text,
            .print-text {
                display: inline !important;
            }
        }
    </style>
</head>

<body>

    <div class="container my-4">
        <div class="prescription-card">

            <!-- Banner -->
            <div class="d-flex justify-content-between">
                <div>
                    <h3 class="m-0">Dr. Your Name</h3>
                    <small>MBBS, FCPS</small><br>
                    <small>Specialist in ...</small>
                </div>
                <div class="text-end">
                    <h5 class="m-0">Hospital / Chamber</h5>
                    <small>Address line 1</small><br>
                    <small>Phone: 01XXXXXXXX</small>
                </div>
            </div>

            <hr>

            <!-- Patient Info -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div><b>Name:</b>
                    <input class="form-control form-control-sm d-inline-block" style="width:200px;">
                    <span class="print-text"></span>
                </div>
                <div><b>Age:</b>
                    <input class="form-control form-control-sm d-inline-block" style="width:100px;">
                    <span class="print-text"></span>
                </div>
                <div><b>Date:</b>
                    <input type="date" class="form-control form-control-sm d-inline-block" style="width:150px;">
                    <span class="print-text"></span>
                </div>
            </div>

            <div class="row">
                <!-- LEFT -->
                <div class="col-md-4">
                    <div class="left-box">
                        <h6><b>C/C :</b></h6>
                        <input class="form-control line-input" type="text" data-type="ul">
                        <ul class="list-cc"></ul>

                        <h6><b>P/E :</b></h6>
                        <input class="form-control line-input" type="text" data-type="ul">
                        <ul class="list-pe"></ul>

                        <h6><b>Advice :</b></h6>
                        <input class="form-control line-input" type="text" data-type="ol">
                        <ol class="list-advice"></ol>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-8">
                    <div class="rx-box">
                        <h4 class="mb-3"><b>Rx</b></h4>

                        <!-- Search -->
                        <div class="no-print mb-3">
                            <input id="searchBox" class="form-control" placeholder="Search drug...">
                            <div id="searchResults" class="border p-2 mt-1" style="display:none; background:#fff;"></div>
                        </div>

                        <!-- Drug List -->
                        <div id="drugList"></div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4 no-print">
                <button onclick="window.print()" class="btn btn-primary px-4">Print Prescription</button>
            </div>

        </div>
    </div>

    <script>
        // Options for Dose & Duration
        const doseOptions = [0.5, 1, 1.5, 2, 3];
        const durationOptions = ["1 day", "3 days", "5 days", "7 days", "10 days"];

        // =======================
        // DYNAMIC SEARCH
        // =======================
        const searchBox = document.getElementById('searchBox');
        const searchResults = document.getElementById('searchResults');
        const drugList = document.getElementById('drugList');

        searchBox.addEventListener('input', function() {
            const keyword = this.value.trim().toLowerCase();
            if (!keyword) return searchResults.style.display = 'none';

            // drugs must come from backend: e.g., const drugs = <?= json_encode($drugs) ?>;
            const filtered = window.drugs.filter(d =>
                d.drug_name.toLowerCase().includes(keyword) ||
                d.drug_type.toLowerCase().includes(keyword) ||
                d.group_name.toLowerCase().includes(keyword) ||
                d.company.toLowerCase().includes(keyword)
            );

            if (filtered.length === 0) {
                searchResults.innerHTML = '<div class="text-muted">No results found</div>';
            } else {
                searchResults.innerHTML = filtered.map(d => `
                    <div class="d-flex justify-content-between border-bottom py-1">
                        <div>
                            <b>${d.drug_name}</b>
                            <small class="text-muted">(${d.drug_type})</small><br>
                            <small class="small-text">${d.company} | ${d.group_name}</small>
                        </div>
                        <button class="btn btn-sm btn-success" onclick='addDrug(${JSON.stringify(d)})'>Add</button>
                    </div>
                `).join('');
            }

            searchResults.style.display = 'block';
        });

        // =======================
        // ADD DRUG
        // =======================
        function addDrug(d) {
            const id = Date.now();
            const doses = doseOptions.map(v => `<option value="${v}">${v}</option>`).join('');
            const durations = durationOptions.map(v => `<option value="${v}">${v}</option>`).join('');

            drugList.insertAdjacentHTML('beforeend', `
                <div class="drug-item" id="drug-${id}">
                    <b>${d.drug_type}. ${d.drug_name}</b> — ${d.quantity}
                    <div class="small-text">${d.group_name} | ${d.company}</div>

                    <div class="mt-1 d-flex align-items-center">
                        <span class="me-2">Dose:</span>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;">${doses}</select>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;">${doses}</select>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;">${doses}</select>

                        <select class="duration-select form-select form-select-sm d-inline-block mx-2" style="width:120px;">
                            <option value="">Duration</option>
                            ${durations}
                        </select>

                        <span class="dose-text d-none ms-2"></span>
                        <span class="duration-text d-none ms-2"></span>
                    </div>

                    <div class="mt-1 d-flex align-items-center">
                        <b>Rule:</b>
                        <input type="text" class="form-control form-control-sm ms-2 w-50 rule-input">
                        <span class="rule-text d-none ms-2"></span>
                    </div>
                </div>
            `);

            // Clear search
            searchBox.value = '';
            searchResults.style.display = 'none';
        }

        // =======================
        // C/C, P/E, Advice ENTER
        // =======================
        document.querySelectorAll('.line-input').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const val = this.value.trim();
                    if (!val) return;

                    const list = this.nextElementSibling;
                    const li = document.createElement(list.tagName.toLowerCase() === 'ul' ? 'li' : 'li');
                    li.innerText = val;
                    list.appendChild(li);
                    this.value = '';
                }
            });
        });

        // =======================
        // BEFORE PRINT
        // =======================
        window.addEventListener('beforeprint', function() {
            // Patient info
            document.querySelectorAll(".container input.form-control, .container input[type=date]").forEach(input => {
                const span = input.nextElementSibling;
                if (span) span.innerText = input.value;
            });

            // Drug dose, duration, rule
            document.querySelectorAll(".drug-item").forEach(drug => {
                // Dose
                const doses = Array.from(drug.querySelectorAll(".dose-select")).map(s => s.value);
                drug.querySelector(".dose-text").innerText = doses.join(" / ");
                drug.querySelector(".dose-text").classList.remove("d-none");

                // Duration
                const duration = drug.querySelector(".duration-select").value;
                drug.querySelector(".duration-text").innerText = duration;
                drug.querySelector(".duration-text").classList.remove("d-none");

                // Rule
                const rule = drug.querySelector(".rule-input").value;
                drug.querySelector(".rule-text").innerText = rule;
                drug.querySelector(".rule-text").classList.remove("d-none");
            });
        });
    </script>

</body>

</html>