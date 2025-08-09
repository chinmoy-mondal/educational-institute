<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="row">
    <!-- Left Profile Column -->
    <div class="col-md-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="<?= !empty($teacher['picture']) ? base_url($teacher['picture']) : base_url('public/assets/img/default-user.png') ?>"
                         alt="Teacher picture"
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>
                <h3 class="profile-username text-center"><?= esc($teacher['name']) ?></h3>
                <p class="text-muted text-center"><?= esc($teacher['designation']) ?></p>
                <p class="text-center"><b><?= esc($teacher['subject']) ?></b></p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Phone</b> <span class="float-right"><?= esc($teacher['phone']) ?></span></li>
                    <li class="list-group-item"><b>Email</b> <span class="float-right"><?= esc($teacher['email']) ?></span></li>
                    <li class="list-group-item"><b>Status</b> <span class="float-right badge bg-success"><?= esc($teacher['account_status']) ?></span></li>
                </ul>

                <a href="<?= base_url('teacher/edit/'.$teacher['id']) ?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
            </div>
        </div>
    </div>

    <!-- Right Content Column -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#personal" data-toggle="tab">Personal Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="#institute" data-toggle="tab">Institute Info</a></li>
                    <li class="nav-item"><a class="nav-link" href="#schedule" data-toggle="tab">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="#attendance" data-toggle="tab">Attendance</a></li>
                    <li class="nav-item"><a class="nav-link" href="#students" data-toggle="tab">Students</a></li>
                    <li class="nav-item"><a class="nav-link" href="#payments" data-toggle="tab">Payments</a></li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content">

                    <!-- Personal Info Tab -->
                    <div class="tab-pane active" id="personal">
                        <table class="table table-bordered">
                            <tr><th>Gender</th><td><?= esc($teacher['gender']) ?></td></tr>
                            <tr><th>Religion</th><td><?= esc($teacher['religion']) ?></td></tr>
                            <tr><th>Blood Group</th><td><?= esc($teacher['blood_group']) ?></td></tr>
                            <tr><th>Joined</th><td><?= esc($teacher['created_at']) ?></td></tr>
                            <tr><th>Last Update</th><td><?= esc($teacher['updated_at']) ?></td></tr>
                        </table>
                    </div>

                    <!-- Institute Info Tab -->
                    <div class="tab-pane" id="institute">
                        <table class="table table-bordered">
                            <tr><th>Designation</th><td><?= esc($teacher['designation']) ?></td></tr>
                            <tr><th>Subject</th><td><?= esc($teacher['subject']) ?></td></tr>
                            <tr><th>Assigned Classes</th><td><?= esc($teacher['assagin_sub']) ?></td></tr>
                            <tr><th>Permit By</th><td><?= esc($teacher['permit_by']) ?></td></tr>
                        </table>
                    </div>

                    <!-- Schedule Tab -->
                    <div class="tab-pane" id="schedule">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Class</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($schedule)): ?>
                                    <?php foreach ($schedule as $row): ?>
                                        <tr>
                                            <td><?= esc($row['day']) ?></td>
                                            <td><?= esc($row['time']) ?></td>
                                            <td><?= esc($row['class_name']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No schedule found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane" id="attendance">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($attendance)): ?>
                                    <?php foreach ($attendance as $row): ?>
                                        <tr>
                                            <td><?= esc($row['date']) ?></td>
                                            <td>
                                                <?php if (strtolower($row['status']) == 'present'): ?>
                                                    <span class="badge bg-success">Present</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Absent</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="2">No attendance records</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Students Tab -->
                    <div class="tab-pane" id="students">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Name</th><th>Class</th><th>Contact</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($students)): ?>
                                    <?php foreach ($students as $s): ?>
                                        <tr>
                                            <td><?= esc($s['name']) ?></td>
                                            <td><?= esc($s['class_name']) ?></td>
                                            <td><?= esc($s['phone']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No students assigned</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payments Tab -->
                    <div class="tab-pane" id="payments">
                        <table class="table table-bordered">
                            <thead>
                                <tr><th>Date</th><th>Amount</th><th>Status</th></tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($payments)): ?>
                                    <?php foreach ($payments as $p): ?>
                                        <tr>
                                            <td><?= esc($p['date']) ?></td>
                                            <td>৳<?= esc(number_format($p['amount'])) ?></td>
                                            <td>
                                                <?php if (strtolower($p['status']) == 'paid'): ?>
                                                    <span class="badge bg-success">Paid</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr><td colspan="3">No payments found</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

