<div class="sidebar" id="sidebar">

    <style>
    .sidebar {
        width: 260px;
        height: 100vh;
        position: fixed;
        background: linear-gradient(180deg, #0f172a, #1e293b);
        padding-top: 20px;
        z-index: 1050;
    }

    .sidebar h4 {
        color: #fff;
        text-align: center;
        margin-bottom: 25px;
    }

    .sidebar a {
        color: #cbd5e1;
        padding: 12px 20px;
        display: block;
        text-decoration: none;
        border-radius: 10px;
        margin: 5px 10px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: linear-gradient(90deg, #6366f1, #22c55e);
        color: white;
        transform: translateX(5px);
    }
    </style>

    <h4>🏥 Clinic Pro</h4>

    <a href="<?= base_url('dashboard') ?>" class="active"><i class="fas fa-home me-2"></i> Dashboard</a>

    <a data-bs-toggle="collapse" href="#patients">Patients</a>
    <div class="collapse" id="patients">
        <a href="#">All Patients</a>
        <a href="#">Add Patient</a>
    </div>

    <a data-bs-toggle="collapse" href="#doctors">Doctors</a>
    <div class="collapse" id="doctors">
        <a href="#">Doctor List</a>
        <a href="#">Add Doctor</a>
    </div>

    <a data-bs-toggle="collapse" href="#app">Appointments</a>
    <div class="collapse" id="app">
        <a href="#">All Appointments</a>
        <a href="#">Book</a>
    </div>

</div>