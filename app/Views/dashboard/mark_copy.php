<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<style>
th, td {
    vertical-align: middle !important;
    text-align: center !important;
    font-size: 10px;
}
.text-danger { color: red; font-weight: bold; }
@media print {
    @page { size: legal landscape; margin: 0.5cm; }
    body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; font-size: 9px; margin:0; padding:0; }
    .no-print, .btn, script { display: none !important; }
    .container-fluid, .card { margin:0 !important; padding:0 !important; box-shadow:none !important; }
    .card-header { background:#333 !important; color:white !important; }
    table { border-collapse: collapse !important; width:100% !important; margin:0; padding:0; font-size:9px; page-break-inside:avoid; }
    table th, table td { padding:0 !important; margin:0 !important; border:1px solid #000 !important; vertical-align:middle !important; text-align:center !important; line-height:1 !important; }
    .rotate { writing-mode: vertical-rl; transform: rotate(180deg); white-space: nowrap; font-size:8px; line-height:1; margin:0 auto; }
}
</style>

<?php
// Check Class 10 Pass/Fail (General & Vocational)
function isClass10Failed($subject, $results, $group = 'general') {
    $data = $results[$subject] ?? ['written'=>0,'mcq'=>0,'practical'=>0];
    $w = $data['written']; $m = $data['mcq']; $p = $data['practical'];

    if($group=='vocational') {
        if(in_array($subject,['Physics-1','Physics-2','Chemistry-1','Chemistry-2'])) return $w<10;
        return $w<20;
    }

    switch($subject){
        case 'Bangla 1st Paper': case 'Bangla 2nd Paper':
            $b1 = $results['Bangla 1st Paper'] ?? ['written'=>0,'mcq'=>0];
            $b2 = $results['Bangla 2nd Paper'] ?? ['written'=>0,'mcq'=>0];
            return ($b1['written']+$b2['written']<46)||($b1['mcq']+$b2['mcq']<20);
        case 'English 1st Paper': case 'English 2nd Paper':
            $e1 = $results['English 1st Paper'] ?? ['written'=>0];
            $e2 = $results['English 2nd Paper'] ?? ['written'=>0];
            return ($e1['written']+$e2['written']<66);
        case 'ICT': return ($w+$m)<7 || $p<8;
        case 'Physics': case 'Chemistry': case 'Higher Math': case 'Biology': return $w<17 || $m<8 || $p<8;
        default: return $w<23 || $m<10;
    }
}

// Collect all subjects
$subjectList = [];
foreach($finalData??[] as $student){
    foreach($student['results']??[] as $r){
        if(!in_array($r['subject'],$subjectList)) $subjectList[] = $r['subject'];
    }
}
?>

<div class="container-fluid" id="printArea">
<h1 class="mb-4">Class 10 Tabulation Sheet</h1>
<div class="card shadow-sm">
<div class="card-header bg-dark text-white">
<h5 class="mb-0">Class: <?= esc($class) ?> | Exam: <?= esc($exam) ?> | Year: <?= esc($year) ?></h5>
</div>
<div class="card-body">
<?php if(empty($finalData)): ?>
<div class="alert alert-warning">No result data found.</div>
<?php else: ?>
<div class="no-print mb-3">
<button class="btn btn-success" onclick="downloadCSV()">Download CSV</button>
<button class="btn btn-primary" onclick="printDiv()">Print / Save as PDF</button>
</div>

<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
<thead class="table-primary text-center">
<tr>
<th rowspan="2">Roll</th><th rowspan="2">Name</th>
<?php foreach($subjectList as $s): ?>
<th colspan="4"><div class="rotate"><?= esc($s) ?></div></th>
<?php endforeach; ?>
<th rowspan="2">Total</th>
</tr>
<tr>
<?php foreach($subjectList as $s): ?>
<th>W</th><th>MCQ</th><th>Prac</th><th>Total</th>
<?php endforeach; ?>
</tr>
</thead>
<tbody>
<?php foreach($finalData as $student):
$map = []; foreach($student['results']??[] as $r) $map[$r['subject']]=$r;
$total=0; $failCount=0; $group=$student['group']??'general';
$banglaFail=false; $englishFail=false;
?>
<tr>
<td><strong><?= esc($student['roll']) ?></strong></td>
<td class="text-start"><?= esc($student['name']) ?></td>
<?php foreach($subjectList as $s):
    $res=$map[$s]??['written'=>0,'mcq'=>0,'practical'=>0,'total'=>0];
    $total+=$res['total']??0;
    $fail = isClass10Failed($s,$map,$group);

    // Count Bangla/English as one fail
    if(in_array($s,['Bangla 1st Paper','Bangla 2nd Paper']) && !$banglaFail && $fail){ $failCount++; $banglaFail=true; }
    elseif(in_array($s,['English 1st Paper','English 2nd Paper']) && !$englishFail && $fail){ $failCount++; $englishFail=true; }
    elseif(!in_array($s,['Bangla 1st Paper','Bangla 2nd Paper','English 1st Paper','English 2nd Paper']) && $fail){ $failCount++; }

    $wc=$mc=$pc='';
    if($group=='vocational'){
        if(in_array($s,['Physics-1','Physics-2','Chemistry-1','Chemistry-2'])) $wc=($res['written']<10?'text-danger fw-bold':'');
        else $wc=($res['written']<20?'text-danger fw-bold':'');
    } else {
        if($s=='ICT'){ if(($res['written']+$res['mcq'])<7) $wc=$mc='text-danger fw-bold'; if($res['practical']<8) $pc='text-danger fw-bold'; }
        elseif(in_array($s,['Physics','Chemistry','Higher Math','Biology'])){ if($res['written']<17)$wc='text-danger fw-bold'; if($res['mcq']<8)$mc='text-danger fw-bold'; if($res['practical']<8)$pc='text-danger fw-bold'; }
        else { if($res['written']<23)$wc='text-danger fw-bold'; if($res['mcq']<10)$mc='text-danger fw-bold'; }
    }
?>
<td class="<?= $wc ?>"><?= $res['written'] ?></td>
<td class="<?= $mc ?>"><?= $res['mcq'] ?></td>
<td class="<?= $pc ?>"><?= $res['practical'] ?></td>
<td class="<?= $fail?'text-danger fw-bold':'' ?>"><?= $res['total'] ?></td>
<?php endforeach; ?>
<td class="fw-bold <?= $failCount>0?'text-danger':'text-success' ?>"><?= $total ?><?= $failCount>0?' <br>F-'.$failCount:'' ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<?php endif; ?>
</div>
</div>
</div>

<script>
function downloadCSV(){ /* same as before */ }
function printDiv(){ window.print(); }
</script>

<?= $this->endSection() ?>