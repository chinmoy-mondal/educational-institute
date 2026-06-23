<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER ACTION -->
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">

        <!-- ADD NEW BUTTON -->
        <a href="<?= base_url('admin/exam-routine/create') ?>" class="btn btn-success">
            + Add New
        </a>

        <!-- SEARCH FILTER -->
        <form method="get" action="<?= current_url() ?>" class="d-flex">

            <!-- EXAM NAME -->
            <input type="text" name="search" value="<?= $_GET['search'] ?? '' ?>"
                class="form-control form-control-sm mr-2" placeholder="Exam Name">

            <!-- DATE -->
            <input type="date" name="date" value="<?= $_GET['date'] ?? '' ?>" class="form-control form-control-sm mr-2">

            <button class="btn btn-primary btn-sm">Search</button>
        </form>

    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Exam Routine List</h3>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Class</th>
                        <th>Subject</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Color</th>
                        <th>Created</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($events)): ?>
                    <?php foreach ($events as $e): ?>
                    <tr>

                        <td><?= $e['id'] ?></td>

                        <td><?= $e['title'] ?></td>

                        <td><?= $e['description'] ?></td>

                        <td>Class <?= $e['class'] ?></td>

                        <!-- SUBJECT -->
                        <td>
                            <?php
                                    $subjectName = '';
                                    foreach ($subjects as $sub) {
                                        if ($sub['id'] == $e['subject']) {
                                            $subjectName = $sub['subject'];
                                            break;
                                        }
                                    }
                                    echo $subjectName;
                                    ?>
                        </td>

                        <td><?= $e['category'] ?></td>

                        <td><?= $e['subcategory'] ?></td>

                        <td><?= $e['start_date'] ?></td>

                        <td><?= $e['end_date'] ?></td>

                        <td><?= $e['start_time'] ?></td>

                        <td><?= $e['end_time'] ?></td>

                        <td>
                            <span style="background:<?= $e['color'] ?>;padding:5px 15px;border-radius:4px;">
                            </span>
                        </td>

                        <td><?= $e['created_at'] ?? '' ?></td>

                        <!-- ACTION -->
                        <td>
                            <a href="<?= base_url('admin/exam-routine/edit/' . $e['id']) ?>"
                                class="btn btn-primary btn-sm">Edit</a>

                            <form action="<?= base_url('admin/exam-routine/delete/' . $e['id']) ?>" method="post"
                                style="display:inline-block;">

                                <?= csrf_field() ?>

                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this routine?')">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="14" class="text-center">No data found</td>
                    </tr>
                    <?php endif; ?>
                </tbody>

            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>