<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Digital Prescription</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #e8f5e9;
            padding: 20px;
            font-family: "Segoe UI", sans-serif;
        }

        .pad-container {
            width: 900px;
            margin: auto;
            background: white;
            border-radius: 8px;
            padding: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .pad-header {
            background: #f7e9c0;
            padding: 20px;
            border-bottom: 2px solid #7b1fa2;
        }

        .doctor-left {
            width: 55%;
            float: left;
        }

        .doctor-right {
            width: 45%;
            float: right;
            text-align: right;
        }

        .clear {
            clear: both;
        }

        .section-left {
            padding: 15px;
            width: 45%;
            min-height: 450px;
            background: #e2f7e1;
        }

        .section-right {
            padding: 15px;
            width: 55%;
            border-left: 2px solid #ccc;
            min-height: 450px;
        }

        .flex-box {
            display: flex;
            width: 100%;
        }

        .rx-symbol {
            font-size: 55px;
            font-weight: bold;
            color: #7b1fa2;
        }

        .drug-item {
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #888;
        }

        .drug-type {
            font-weight: 700;
        }

        .group-name {
            font-size: 11px;
            color: #777;
        }

        /* Print Style */
        @media print {

            input,
            textarea {
                border: none !important;
                outline: none !important;
            }

            button,
            .search-box {
                display: none !important;
            }

            body {
                background: white;
            }

            .pad-container {
                box-shadow: none;
                width: 100%;
                margin: 0;
            }

            .section-left,
            .section-right {
                min-height: 400px;
            }
        }
    </style>
</head>

<body>

    <div class="pad-container">

        <!-- HEADER -->
        <div class="pad-header">
            <div class="doctor-left">
                <h3 class="text-danger fw-bold">ডাঃ মোছাঃ রিমা</h3>
                <div>MBBS (RMC)</div>
                <div>MCPS (Internal Medicine)</div>
                <div>FCPS (Medicine)</div>
                <div>Consultant - Medicine</div>
                <div class="mt-2">Rangpur Medical College Hospital</div>
            </div>

            <div class="doctor-right">
                <div><b>Reg No:</b> 12345</div>
                <div><b>Chamber:</b> Modern Diagnostic Center</div>
                <div><b>Time:</b> 4 PM – 9 PM</div>
            </div>

            <div class="clear"></div>

            <hr>

            <!-- Patient Info -->
            <div class="d-flex">
                <div class="me-3">
                    <label>নামঃ</label>
                    <input type="text" class="form-control form-control-sm">
                </div>

                <div class="me-3">
                    <label>বয়সঃ</label>
                    <input type="text" class="form-control form-control-sm">
                </div>

                <div>
                    <label>তারিখঃ</label>
                    <input type="date" class="form-control form-control-sm">
                </div>
            </div>

        </div>

        <div class="flex-box">

            <!-- LEFT SIDE (C/C, P/E, Advice) -->
            <div class="section-left">
                <b>C/C (Chief Complain)</b>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <b>P/E (On Examination)</b>
                <textarea rows="4" class="form-control mb-3"></textarea>

                <b>Advice</b>
                <textarea rows="4" class="form-control"></textarea>
            </div>

            <!-- RIGHT SIDE (Prescription) -->
            <div class="section-right">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="rx-symbol">℞</div>

                    <div class="search-box">
                        <input id="searchDrug" type="text" class="form-control" placeholder="Search drug...">
                        <div id="searchResults" class="list-group mt-1"></div>
                    </div>
                </div>

                <div id="drugList"></div>

            </div>

        </div>

    </div>

<script>
let count = 1;

document.getElementById("searchDrug").addEventListener("keyup", function () {

    let keyword = this.value.trim();
    let resultsDiv = document.getElementById("searchResults");
    resultsDiv.innerHTML = "";

    if (keyword.length < 1) return;

    fetch(`/search-drugs?q=` + keyword)
        .then(res => res.json())
        .then(list => {

            resultsDiv.innerHTML = "";

            list.forEach(d => {

                resultsDiv.innerHTML += `
                    <div class="list-group-item d-flex justify-content-between">
                        <div>
                            <b>${d.drug_name}</b> (${d.quantity} ${d.unit_type})
                            <br><small>${d.group_name}</small>
                        </div>
                        <button class="btn btn-sm btn-success"
                             onclick='addDrug(${JSON.stringify(d)})'>
                             Add
                        </button>
                    </div>`;
            });
        });
});

function addDrug(d) {

    let html = `
        <div class="drug-item">
            <div><b>${count}. ${d.drug_type}. ${d.drug_name} ${d.quantity}${d.unit_type}</b></div>
            <div class="group-name">${d.group_name}</div>

            <div class="d-flex mt-1">
                <div class="me-2">
                    Dose:
                    <input type="text" class="form-control form-control-sm" placeholder="1+1+1">
                </div>

                <div>
                    Duration:
                    <input type="text" class="form-control form-control-sm" placeholder="5 days">
                </div>
            </div>
        </div>
    `;

    document.getElementById("drugList").insertAdjacentHTML("beforeend", html);

    count++;

    document.getElementById("searchDrug").value = "";
    document.getElementById("searchResults").innerHTML = "";
}
</script>

</body>

</html>