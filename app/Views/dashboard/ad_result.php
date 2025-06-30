<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<!-- Responsive widths for mark inputs -->
<style>
    /* default -- mobile first */
    .mark-input  { width:50px; }

    /* ≥ 576 px (Bootstrap’s sm breakpoint) */
    @media (min-width:576px) {
        .mark-input { width:80px; }
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- ── Header info ── -->
                    <div class="mb-4 text-center">
                        <h4 class="mb-1">Enter Marks for Students</h4>
                        <p class="mb-0">
                            <strong>Subject:</strong> <?= esc($subject['subject']) ?> |
                            <strong>Class:</strong> <?= esc($subject['class']) ?> |
                            <strong>Section:</strong> <?= esc($subject['section']) ?>
                        </p>
                        <p class="text-muted">
                            <strong>Teacher:</strong> <?= esc($user['name']) ?><?php if ($user['designation']): ?> (<?= esc($user['designation']) ?>)<?php endif ?>
                        </p>
                    </div>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('results/submit') ?>" onsubmit="return validateTotals();">
                        <input type="hidden" name="exam"       value="Midterm">
                        <input type="hidden" name="year"       value="<?= date('Y') ?>">
                        <input type="hidden" name="subject_id" value="<?= esc($subject['id']) ?>">

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th><th>Student Name</th><th>Roll</th><th>Class</th>
                                        <th>Written</th><th>MCQ</th><th>Practical</th><th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($students as $i => $s): ?>
                                    <tr>
                                        <td><?= $i+1 ?></td>
                                        <td><?= esc($s['student_name']) ?>
                                            <input type="hidden" name="students[<?= $i ?>][id]" value="<?= esc($s['id']) ?>">
                                        </td>
                                        <td><?= esc($s['roll']) ?></td>
                                        <td><?= esc($s['class']) ?></td>

                                        <?php foreach (['written','mcq','practical'] as $field): ?>
                                            <td class="mark-cell">
                                                <input type="number"
                                                       name="students[<?= $i ?>][<?= $field ?>]"
                                                       class="form-control mark-input text-center"
                                                       min="0" max="100"
                                                       oninput="updateTotal(<?= $i ?>)"
                                                       onkeydown="moveWithArrow(event)">
                                            </td>
                                        <?php endforeach; ?>

                                        <td>
                                            <input type="number"
                                                   name="students[<?= $i ?>][total]"
                                                   id="total-<?= $i ?>"
                                                   class="form-control bg-light text-center"
                                                   readonly>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-end mt-3">
                            <button class="btn btn-primary px-4">Submit Results</button>
                        </div>
                    </form>

                    <script>
                        /* live total */
                        function updateTotal(i) {
                            const f = name => parseFloat(document.querySelector(`[name="students[${i}][${name}]"]`).value)||0;
                            document.getElementById(`total-${i}`).value = f('written')+f('mcq')+f('practical');
                        }

                        /* arrow-key navigation */
                        function moveWithArrow(e){
                            const td=e.target.closest('td'); if(!td||!td.classList.contains('mark-cell'))return;
                            const dir={ArrowRight:1,ArrowLeft:-1}[e.key];
                            if(dir){let n=td;do{n=dir>0?n.nextElementSibling:n.previousElementSibling}while(n&& !n.classList.contains('mark-cell'));
                                if(n){e.preventDefault();n.querySelector('input').focus();}} 
                            if(e.key==='ArrowUp'||e.key==='ArrowDown'){
                                const row=td.parentElement, idx=td.cellIndex;
                                const r=e.key==='ArrowUp'?row.previousElementSibling:row.nextElementSibling;
                                if(r&&r.cells[idx].classList.contains('mark-cell')){e.preventDefault();r.cells[idx].querySelector('input').focus();}
                            }
                        }

                        /* block totals >100 */
                        function validateTotals(){
                            for(const t of document.querySelectorAll('[id^="total-"]'))
                                if((+t.value)>100){alert('Total must be ≤ 100');t.focus();return false;}
                            return true;
                        }
                    </script>

                </div>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>
