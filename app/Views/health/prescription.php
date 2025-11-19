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

        @media print {
            .no-print {
                display: none !important;
            }

            input,
            button,
            select {
                display: none !important;
            }

            .dose-text,
            .duration-text {
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
                <div><b>Name:</b> <input class="form-control form-control-sm d-inline-block" style="width:200px;"></div>
                <div><b>Age:</b> <input class="form-control form-control-sm d-inline-block" style="width:100px;"></div>
                <div><b>Date:</b> <input type="date" class="form-control form-control-sm d-inline-block" style="width:150px;"></div>
            </div>

            <div class="row">
                <!-- LEFT -->
                <div class="col-md-6">
                    <div class="left-box">
                        <h6><b>C/C :</b></h6>
                        <textarea class="form-control mb-3" rows="2"></textarea>

                        <h6><b>P/E :</b></h6>
                        <textarea class="form-control mb-3" rows="2"></textarea>

                        <h6><b>Advice :</b></h6>
                        <textarea class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-6">
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
        const drugs = [{
                type: "Tablet",
                name: "Napa 500",
                qty: "10 pcs",
                group: "Paracetamol",
                company: "Beximco",
                rule: "Take after meals"
            },
            {
                type: "Capsule",
                name: "Omep 20",
                qty: "14 pcs",
                group: "Omeprazole",
                company: "Incepta",
                rule: "Take before breakfast"
            },
            {
                type: "Syrup",
                name: "Histacin",
                qty: "100 ml",
                group: "Antihistamine",
                company: "ACME",
                rule: "Shake well before use"
            },
            {
                type: "Tablet",
                name: "Ace Plus",
                qty: "10 pcs",
                group: "Paracetamol+Caffeine",
                company: "Eskayef",
                rule: "Avoid if hypertensive"
            },
        ];

        // Search drugs
        document.getElementById("searchBox").addEventListener("keyup", function() {
            const keyword = this.value.toLowerCase();
            const resultBox = document.getElementById("searchResults");

            if (!keyword) {
                resultBox.style.display = "none";
                return;
            }

            const filtered = drugs.filter(d =>
                d.name.toLowerCase().includes(keyword) ||
                d.type.toLowerCase().includes(keyword) ||
                d.group.toLowerCase().includes(keyword) ||
                d.company.toLowerCase().includes(keyword)
            );

            resultBox.innerHTML = filtered.map(d => `
                <div class="d-flex justify-content-between border-bottom py-1">
                    <div>
                        <b>${d.name}</b>  
                        <small class="text-muted">(${d.type})</small><br>
                        <small class="small-text">${d.company} | ${d.group}</small>
                    </div>
                    <button class="btn btn-sm btn-success" onclick='addDrug(${JSON.stringify(d)})'>Add</button>
                </div>
            `).join("");

            resultBox.style.display = "block";
        });

        function addDrug(d) {
            const box = document.getElementById("drugList");
            const id = Date.now();

            box.innerHTML += `
            <div class="drug-item" id="drug-${id}">
                <b>${d.type}. ${d.name}</b> — ${d.qty}
                <div class="small-text">${d.group} | ${d.company}</div>

                <div class="mt-1">
                    Dose:
                    <input class="dose-input form-control form-control-sm d-inline-block" style="width:200px;" oninput="updateDrug(${id})">
                    <span class="dose-text d-none"></span>
                </div>

                <div class="mt-1">
                    Duration:
                    <select multiple class="duration-select form-select form-select-sm d-inline-block" style="width:250px;" onchange="updateDrug(${id})">
                        <option value="1 day">1 day</option>
                        <option value="3 days">3 days</option>
                        <option value="5 days">5 days</option>
                        <option value="7 days">7 days</option>
                        <option value="10 days">10 days</option>
                        <option value="Custom">Custom Date</option>
                    </select>
                    <input type="date" class="duration-date form-control form-control-sm d-inline-block mt-1" style="width:150px; display:none;" onchange="updateDrug(${id})">
                    <span class="duration-text d-none"></span>
                </div>

                <div class="mt-1"><b>Rule:</b> ${d.rule}</div>
            </div>`;
        }

        function updateDrug(id) {
            const drug = document.getElementById("drug-" + id);
            const doseInput = drug.querySelector(".dose-input");
            const durationSelect = drug.querySelector(".duration-select");
            const durationDate = drug.querySelector(".duration-date");

            // Show/hide custom date
            if ([...durationSelect.selectedOptions].some(o => o.value === "Custom")) {
                durationDate.style.display = "inline-block";
            } else {
                durationDate.style.display = "none";
                durationDate.value = "";
            }

            const doseVal = doseInput.value.trim();
            let durations = [...durationSelect.selectedOptions].map(o => o.value).filter(v => v !== "Custom");
            if (durationDate.value) durations.push(durationDate.value);

            // Show text if both dose and duration exist
            if (doseVal && durations.length > 0) {
                doseInput.classList.add("d-none");
                drug.querySelector(".dose-text").innerText = doseVal;
                drug.querySelector(".dose-text").classList.remove("d-none");

                durationSelect.classList.add("d-none");
                durationDate.classList.add("d-none");
                drug.querySelector(".duration-text").innerText = durations.join(", ");
                drug.querySelector(".duration-text").classList.remove("d-none");
            } else {
                doseInput.classList.remove("d-none");
                drug.querySelector(".dose-text").classList.add("d-none");

                durationSelect.classList.remove("d-none");
                if ([...durationSelect.selectedOptions].some(o => o.value === "Custom") && !durationDate.value) {
                    durationDate.style.display = "inline-block";
                }
                drug.querySelector(".duration-text").classList.add("d-none");
            }
        }
    </script>
</body>

</html>