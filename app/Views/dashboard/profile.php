<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Profile Header -->
<div class="row">
    <div class="col-md-8">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="<?= !empty(session('picture')) ? base_url(session('picture')) : base_url('public/assets/img/default-user.png') ?>"
                         alt="User profile picture"
                         style="width: 100px; height: 100px; object-fit: cover;">
                </div>

                <h3 class="profile-username text-center"><?= esc(session('name')) ?></h3>
                <p class="text-muted text-center"><?= esc(session('designation') ?? 'N/A') ?></p>

                <div class="text-center mb-3">
                    <span class="badge bg-primary"><?= esc(session('role')) ?></span>
                    <span class="badge bg-success"><?= ucfirst(session('account_status')) ?></span>
                </div>

                <!-- Stats Row -->
                <div class="row text-center">
                    <div class="col">
                        <h5>8+</h5>
                        <small>Years Experience</small>
                    </div>
                    <div class="col">
                        <h5>232</h5>
                        <small>Lessons Conducted</small>
                    </div>
                    <div class="col">
                        <h5>250+</h5>
                        <small>Students</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#schedule" data-toggle="tab">Schedule</a></li>
                    <li class="nav-item"><a class="nav-link" href="#courses" data-toggle="tab">Courses</a></li>
                    <li class="nav-item"><a class="nav-link" href="#resume" data-toggle="tab">Resume</a></li>
                    <li class="nav-item"><a class="nav-link" href="#lessons" data-toggle="tab">Lessons</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">

                    <!-- Schedule Tab -->
                    <div class="tab-pane active" id="schedule">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thu</th>
                                    <th>Fri</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>08:00</td>
                                    <td>English Grammar</td>
                                    <td></td>
                                    <td>English Grammar</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>11:00</td>
                                    <td>Spoken English</td>
                                    <td></td>
                                    <td>Spoken English</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Courses Tab -->
                    <div class="tab-pane" id="courses">
                        <p>List of courses will go here...</p>
                    </div>

                    <!-- Resume Tab -->
                    <div class="tab-pane" id="resume">
                        <p>Resume / career info goes here...</p>
                    </div>

                    <!-- Lessons Tab -->
                    <div class="tab-pane" id="lessons">
                        <p>Lesson details go here...</p>
                    </div>

                </div>
            </div>
        </div>

    </div>

    <!-- Right Column (Reviews & Info) -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Reviews</h3></div>
            <div class="card-body">
                <div class="mb-2">
                    <h4>4.9 <small>/ 5</small></h4>
                    <div class="text-warning">
                        ★★★★☆
                    </div>
                    <small>236 reviews</small>
                </div>
                <div class="progress-group">Qualifications
                    <span class="float-right"><b>4.9</b></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: 98%"></div>
                    </div>
                </div>
                <div class="progress-group">Expertise
                    <span class="float-right"><b>4.2</b></span>
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-info" style="width: 84%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lesson Price -->
        <div class="card">
            <div class="card-body">
                <h5>Price Per Lesson</h5>
                <p><strong>$32/hr</strong></p>
                <small>7 lessons booked in last 48 hours</small><br>
                <small>4-hour response time</small>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>