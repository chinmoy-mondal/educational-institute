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
            margin-top: -5px;
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
            button {
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
                    <h5 class="m-0">Your Hospital / Chamber</h5>
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
        // Updated drug list with company
        const drugs = [{
                type: "Tablet",
                name: "Napa 500",
                qty: "10 pcs",
                group: "Paracetamol",
                company: "Beximco"
            },
            {
                type: "Capsule",
                name: "Omep 20",
                qty: "14 pcs",
                group: "Omeprazole",
                company: "Incepta"
            },
            {
                type: "Syrup",
                name: "Histacin",
                qty: "100 ml",
                group: "Antihistamine",
                company: "ACME"
            },
            {
                type: "Tablet",
                name: "Ace Plus",
                qty: "10 pcs",
                group: "Paracetamol+Caffeine",
                company: "Eskayef"
            },
        ];

        // search
        document.getElementById("searchBox").addEventListener("keyup", function() {
            let keyword = this.value.toLowerCase();
            let resultBox = document.getElementById("searchResults");

            if (keyword.length < 1) {
                resultBox.style.display = "none";
                return;
            }

            let filtered = drugs.filter(d =>
                d.name.toLowerCase().includes(keyword) ||
                d.company.toLowerCase().includes(keyword) ||
                d.type.toLowerCase().includes(keyword)
            );

            resultBox.innerHTML = "";

            filtered.forEach(d => {
                resultBox.innerHTML += `
            <div class="d-flex justify-content-between border-bottom py-1">
                <div>
                    <b>${d.name}</b>  
                    <small class="text-muted">(${d.type})</small><br>
                    <small class="small-text">${d.company}</small>
                </div>
                <button class="btn btn-sm btn-success" onclick='addDrug(${JSON.stringify(d)})'>Add</button>
            </div>`;
            });

            resultBox.style.display = "block";
        });

        function addDrug(d) {
            let box = document.getElementById("drugList");
            let id = Date.now();

            box.innerHTML += `
        <div class="drug-item" id="drug-${id}">
            <b>${d.type}. ${d.name}</b> — ${d.qty}
            <div class="small-text">${d.group} | ${d.company}</div>

            <div class="mt-1">
                Dose:
                <input class="dose-input form-control form-control-sm d-inline-block" style="width:200px;"
                       oninput="updateText(${id})">
                <span class="dose-text d-none"></span>
            </div>

            <div class="mt-1">
                Duration:
                <input class="duration-input form-control form-control-sm d-inline-block" style="width:150px;"
                       oninput="updateText(${id})">
                <span class="duration-text d-none"></span>
            </div>
        </div>`;
        }

        function updateText(id) {
            let drug = document.getElementById("drug-" + id);

            drug.querySelector(".dose-text").innerText =
                drug.querySelector(".dose-input").value;

            drug.querySelector(".duration-text").innerText =
                drug.querySelector(".duration-input").value;
        }
    </script>

</body>

</html>