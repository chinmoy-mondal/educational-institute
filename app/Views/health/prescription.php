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

        .editable-text {
            cursor: pointer;
            border-bottom: 1px dashed #aaa;
            padding: 2px;
            display: inline-block;
        }

        .add-btn-phone {
            display: none;
            margin-top: 4px;
        }

        @media print {

            input,
            select,
            button {
                display: none !important;
            }

            .dose-label,
            .dose-select,
            .duration-select,
            .no-print {
                display: none !important;
            }

            .dose-text,
            .duration-text,
            .rule-text,
            .print-text {
                display: inline !important;
            }
        }

        @media (max-width: 768px) {

            /* Show add button on mobile */
            .add-btn-phone {
                display: inline-block;
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

                <div>
                    <b>Name:</b>
                    <input id="nameInput" class="form-control form-control-sm d-inline-block" style="width:200px;">
                    <span id="nameText" class="d-none print-text"></span>
                </div>

                <div>
                    <b>Age:</b>
                    <input id="ageInput" class="form-control form-control-sm d-inline-block" style="width:100px;">
                    <span id="ageText" class="d-none print-text"></span>
                </div>

                <div>
                    <b>Date:</b>
                    <input id="dateInput" type="date" class="form-control form-control-sm d-inline-block" style="width:150px;">
                    <span id="dateText" class="d-none print-text"></span>
                </div>

            </div>

            <div class="row">
                <!-- LEFT: 4 columns -->
                <div class="col-md-4">
                    <div class="left-box">
                        <h6><b>C/C :</b></h6>
                        <input class="form-control mb-1 line-input" type="text" data-type="ul">
                        <button type="button" class="btn btn-sm btn-primary add-btn-phone" onclick="addLine(this)">Add</button>
                        <ul class="list-cc"></ul>

                        <h6><b>P/E :</b></h6>
                        <input class="form-control mb-1 line-input" type="text" data-type="ul">
                        <button type="button" class="btn btn-sm btn-primary add-btn-phone" onclick="addLine(this)">Add</button>
                        <ul class="list-pe"></ul>

                        <h6><b>Advice :</b></h6>
                        <input class="form-control mb-1 line-input" type="text" data-type="ol">
                        <button type="button" class="btn btn-sm btn-primary add-btn-phone" onclick="addLine(this)">Add</button>
                        <ol class="list-advice"></ol>
                    </div>
                </div>

                <!-- RIGHT: 8 columns -->
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
        let drugs = <?= $drugs_json ?> || [];

        // Auto-set date
        const dateInput = document.getElementById("dateInput");
        if (dateInput) {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            dateInput.value = `${yyyy}-${mm}-${dd}`;
        }

        const doseOptions = [0, 0.5, 1, 1.5, 2, 3];
        const durationOptions = [
            "Continue", "1 day", "2 days", "3 days", "4 days", "5 days", "6 days", "7 days",
            "8 days", "9 days", "10 days", "11 days", "12 days", "13 days", "14 days",
            "15 days", "16 days", "17 days", "18 days", "19 days", "20 days", "21 days",
            "22 days", "23 days", "24 days", "25 days", "26 days", "27 days", "28 days",
            "29 days", "30 days", "31 days",
            "1 month", "2 months", "3 months", "4 months", "5 months", "6 months",
            "7 months", "8 months", "9 months", "10 months", "11 months", "12 months"
        ];

        const searchBox = document.getElementById("searchBox");
        const searchResults = document.getElementById("searchResults");
        const drugList = document.getElementById("drugList");

        searchBox && searchBox.addEventListener("keyup", function() {
            const keyword = this.value.trim().toLowerCase();
            if (!keyword) {
                searchResults.style.display = "none";
                return;
            }

            const filtered = (drugs || []).filter(d =>
                (d.drug_name || "").toLowerCase().includes(keyword) ||
                (d.drug_type || "").toLowerCase().includes(keyword) ||
                (d.group_name || "").toLowerCase().includes(keyword) ||
                (d.company || "").toLowerCase().includes(keyword)
            );

            searchResults.innerHTML = filtered.length ? filtered.map(d => `
                <div class="d-flex justify-content-between border-bottom py-1">
                    <div>
                        <b>${escapeHtml(d.drug_name)}</b>
                        <small class="text-muted">(${escapeHtml(d.drug_type)})</small><br>
                        <small class="small-text">${escapeHtml(d.company)} | ${escapeHtml(d.group_name)}</small>
                    </div>
                    <button class="btn btn-sm btn-success" onclick='addDrug(${JSON.stringify(d)})'>Add</button>
                </div>
            `).join('') : '<div class="text-muted">No results found</div>';

            searchResults.style.display = "block";
        });

        function escapeHtml(str) {
            if (!str && str !== 0) return "";
            return String(str)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#39;');
        }

        function addLine(btn) {
            const input = btn.previousElementSibling;
            const list = input.nextElementSibling;
            const val = input.value.trim();
            if (!val) return;
            const li = document.createElement("li");
            li.innerText = val;
            list.appendChild(li);
            input.value = "";
        }

        // Enter key functionality for desktop
        document.querySelectorAll(".line-input").forEach(input => {
            input.addEventListener("keydown", function(e) {
                if (e.key === "Enter" && window.innerWidth > 768) {
                    e.preventDefault();
                    const val = this.value.trim();
                    if (!val) return;
                    const list = this.nextElementSibling.nextElementSibling;
                    const li = document.createElement("li");
                    li.innerText = val;
                    list.appendChild(li);
                    this.value = "";
                }
            });
        });

        function addDrug(d) {
            const id = Date.now();
            const doses = doseOptions.map(v => `<option value="${v}">${v}</option>`).join('');
            const durations = durationOptions.map(v => `<option value="${escapeHtml(v)}">${escapeHtml(v)}</option>`).join('');

            drugList.insertAdjacentHTML('beforeend', `
                <div class="drug-item" id="drug-${id}">
                    <b>${escapeHtml(d.drug_type)}. ${escapeHtml(d.drug_name)}</b> — ${escapeHtml(d.quantity || "")} ${escapeHtml(d.unit_type || "")}
                    <div class="small-text">${escapeHtml(d.group_name || "")} | ${escapeHtml(d.company || "")}</div>

                    <div class="mt-1 d-flex align-items-center">
                        <span class="me-2 dose-label">Dose:</span>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;" onchange="updateDrug(${id})">${doses}</select>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;" onchange="updateDrug(${id})">${doses}</select>
                        <select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;" onchange="updateDrug(${id})">${doses}</select>

                        <select class="duration-select form-select form-select-sm d-inline-block mx-2" style="width:140px;" onchange="updateDrug(${id})">
                            <option value="">Duration</option>
                            ${durations}
                        </select>

                        <span class="dose-text d-none ms-2"></span>
                        <span class="duration-text d-none ms-2"></span>
                    </div>

                    <div class="mt-1 d-flex align-items-center">
                        <b>Rule:</b>
                        <input type="text" class="form-control form-control-sm ms-2 w-50 rule-input" placeholder="Enter rule">
                        <span class="rule-text d-none ms-2"></span>
                    </div>
                </div>
            `);
        }
    </script>
</body>

</html>