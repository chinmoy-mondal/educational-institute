<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <h3>Digital Prescription</h3>

    <form action="<?= base_url('health/prescription/save') ?>" method="POST">

        <div class="card mb-3">
            <div class="card-header">Patient Information</div>
            <div class="card-body">

                <div class="mb-3">
                    <label>Patient Name</label>
                    <input type="text" name="patient_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Age</label>
                    <input type="text" name="patient_age" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Diagnosis</label>
                    <textarea name="diagnosis" class="form-control"></textarea>
                </div>

            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">Medicines</div>
            <div class="card-body">

                <table class="table" id="medTable">
                    <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Dose</th>
                            <th>Duration</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <select name="medicine[0][drug]" class="form-control">
                                    <?php foreach ($drugs as $d): ?>
                                        <option value="<?= $d['drug_name'] ?>">
                                            <?= $d['drug_name'] ?> (<?= $d['unit_type'] ?>)
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </td>

                            <td><input type="text" name="medicine[0][dose]" class="form-control"></td>
                            <td><input type="text" name="medicine[0][duration]" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger remove-row">X</button></td>
                        </tr>
                    </tbody>
                </table>

                <button type="button" id="addRow" class="btn btn-primary">+ Add Medicine</button>

            </div>
        </div>

        <button class="btn btn-success btn-lg">Submit</button>

    </form>
</div>

<script>
    let row = 1;

    document.getElementById("addRow").onclick = function() {
        let table = document.querySelector("#medTable tbody");

        let html = `
        <tr>
            <td>
                <select name="medicine[${row}][drug]" class="form-control">
                    <?php foreach ($drugs as $d): ?>
                        <option value="<?= $d['drug_name'] ?>"><?= $d['drug_name'] ?> (<?= $d['unit_type'] ?>)</option>
                    <?php endforeach ?>
                </select>
            </td>
            <td><input type="text" name="medicine[${row}][dose]" class="form-control"></td>
            <td><input type="text" name="medicine[${row}][duration]" class="form-control"></td>
            <td><button type="button" class="btn btn-danger remove-row">X</button></td>
        </tr>
    `;

        table.insertAdjacentHTML("beforeend", html);
        row++;
    };

    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("remove-row")) {
            e.target.closest("tr").remove();
        }
    });
</script>

<?= $this->endSection() ?>