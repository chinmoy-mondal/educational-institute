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

            .print-text,
            .dose-text,
            .duration-text,
            .rule-text,
            .list-cc li,
            .list-pe li,
            .list-advice li {
                display: inline !important;
            }

            .list-cc,
            .list-pe,
            .list-advice {
                padding-left: 0;
                margin-bottom: 0;
            }

            .drug-item .small-text {
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
        const drugs = [{
                drug_name: "Napa 500",
                drug_type: "Tablet",
                quantity: "10 pcs",
                group_name: "Paracetamol",
                company: "Beximco"
            },
            {
                drug_name: "Omep 20",
                drug_type: "Capsule",
                quantity: "14 pcs",
                group_name: "Omeprazole",
                company: "Incepta"
            },
            {
                drug_name: "Histacin",
                drug_type: "Syrup",
                quantity: "100 ml",
                group_name: "Antihistamine",
                company: "ACME"
            },
            {
                drug_name: "Ace Plus",
                drug_type: "Tablet",
                quantity: "10 pcs",
                group_name: "Paracetamol+Caffeine",
                company: "Eskayef"
            },
        ];

        const doseOptions = [0.5, 1, 1.5, 2, 3];
        const durationOptions = ["1 day", "3 days", "5 days", "7 days", "10 days"];

        // Drug Search
        document.getElementById("searchBox").addEventListener("keyup", function() {
            const keyword = this.value.toLowerCase();
            const resultBox = document.getElementById("searchResults");
            if (!keyword) {
                resultBox.style.display = "none";
                return;
            }

            const filtered = drugs.filter(d =>
                d.drug_name.toLowerCase().includes(keyword) ||
                d.drug_type.toLowerCase().includes(keyword) ||
                d.group_name.toLowerCase().includes(keyword) ||
                d.company.toLowerCase().includes(keyword)
            );

            resultBox.innerHTML = filtered.map(d => `
                <div class="d-flex justify-content-between border-bottom py-1">
                    <div>
                        <b>${d.drug_name}</b>  
                        <small class="text-muted">(${d.drug_type})</small><br>
                        <small class="small-text">${d.company} | ${d.group_name}</small>
                    </div>
                    <button class="btn btn-sm btn-success" onclick='addDrug(${JSON.stringify(d)})'>Add</button>
                </div>
            `).join("");
            resultBox.style.display = "block";
        });

        // Add Drug
        function addDrug(d) {
            const box = document.getElementById("drugList");
            const id = Date.now();

            box.innerHTML += `
                <div class="drug-item" id="drug-${id}">
                    <b>${d.drug_type}. ${d.drug_name}</b> — ${d.quantity}
                    <div class="small-text">${d.group_name} | ${d.company}</div>

                    <div class="mt-1 d-flex align-items-center">
                        <span class="me-2">Dose:</span>
                        ${doseOptions.map(v => `<select class="dose-select form-select form-select-sm d-inline-block mx-1" style="width:70px;"><option value="${v}">${v}</option></select>`).join('')}
                        <select class="duration-select form-select form-select-sm d-inline-block mx-2" style="width:120px;">
                            <option value="">Duration</option>
                            ${durationOptions.map(d => `<option value="${d}">${d}</option>`).join('')}
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
            `;

            document.getElementById("searchBox").value = "";
            document.getElementById("searchResults").style.display = "none";
        }

        // Enter to add C/C, P/E, Advice
        document.querySelectorAll(".line-input").forEach(input => {
            input.addEventListener("keydown", function(e) {
                if (e.key === "Enter") {
                    e.preventDefault();
                    const val = this.value.trim();
                    if (!val) return;
                    let list = this.nextElementSibling;
                    const li = document.createElement("li");
                    li.innerText = val;
                    list.appendChild(li);
                    this.value = "";
                }
            });
        });

        // Before print: copy all input/select values to spans
        window.addEventListener("beforeprint", function() {
            // Name, Age, Date
            document.querySelectorAll(".container input.form-control, .container input[type=date]").forEach(input => {
                const span = input.nextElementSibling;
                span.innerText = input.value;
            });

            // CC, PE, Advice lists
            document.querySelectorAll(".line-input").forEach(input => {
                const list = input.nextElementSibling;
                Array.from(list.children).forEach(li => li.style.display = "list-item");
            });

            // Rules
            document.querySelectorAll(".rule-input").forEach(input => {
                const span = input.nextElementSibling;
                span.innerText = input.value;
                span.classList.remove("d-none");
            });

            // Dose & Duration
            document.querySelectorAll(".drug-item").forEach(drug => {
                const doses = Array.from(drug.querySelectorAll(".dose-select")).map(s => s.value);
                const duration = drug.querySelector(".duration-select").value;

                const doseText = drug.querySelector(".dose-text");
                const durText = drug.querySelector(".duration-text");

                doseText.innerText = doses.join(" / ");
                durText.innerText = duration;

                doseText.classList.remove("d-none");
                durText.classList.remove("d-none");
            });
        });
    </script>

</body>

</html>