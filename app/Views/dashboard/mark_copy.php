<?php

function isSubjectFailedClass10(string $subject, array $allSubjects, string $group = 'general'): bool
{
    if (!isset($allSubjects[$subject])) return false;

    $data = $allSubjects[$subject];
    $written = is_numeric($data['written']) ? $data['written'] : 0;
    $mcq = is_numeric($data['mcq']) ? $data['mcq'] : 0;
    $practical = is_numeric($data['practical']) ? $data['practical'] : 0;

    // Vocational Group Rules
    if ($group === 'vocational') {
        if (in_array($subject, ['Physics-1', 'Physics-2', 'Chemistry-1', 'Chemistry-2'])) {
            return $written < 10;
        }
        return $written < 20;
    }

    // General Group Rules
    switch ($subject) {
        case 'Bangla 1st Paper':
        case 'Bangla 2nd Paper':
            $b1 = $allSubjects['Bangla 1st Paper'] ?? ['written' => 0, 'mcq' => 0];
            $b2 = $allSubjects['Bangla 2nd Paper'] ?? ['written' => 0, 'mcq' => 0];
            return ($b1['written'] + $b2['written'] < 46) || ($b1['mcq'] + $b2['mcq'] < 20);

        case 'English 1st Paper':
        case 'English 2nd Paper':
            $e1 = $allSubjects['English 1st Paper'] ?? ['written' => 0];
            $e2 = $allSubjects['English 2nd Paper'] ?? ['written' => 0];
            return ($e1['written'] + $e2['written'] < 66);

        case 'ICT':
            return ($written + $mcq) < 7 || $practical < 8;

        case 'Physics':
        case 'Chemistry':
        case 'Higher Math':
        case 'Biology':
            return $written < 17 || $mcq < 8 || $practical < 8;

        default:
            return $written < 23 || $mcq < 10;
    }
}

// Sample student data
$studentSubjectsGeneral = [
    'ICT' => ['written' => 23, 'mcq' => 0, 'practical' => 23, 'total' => 46],
    'Bangla 1st Paper' => ['written' => 25, 'mcq' => 10, 'practical' => 0, 'total' => 35],
    'Bangla 2nd Paper' => ['written' => 23, 'mcq' => 10, 'practical' => 0, 'total' => 33],
    'English 1st Paper' => ['written' => 35, 'mcq' => 0, 'practical' => 0, 'total' => 35],
    'English 2nd Paper' => ['written' => 31, 'mcq' => 0, 'practical' => 0, 'total' => 31],
    'Physics' => ['written' => 18, 'mcq' => 9, 'practical' => 8, 'total' => 35],
    'Chemistry' => ['written' => 16, 'mcq' => 8, 'practical' => 8, 'total' => 32],
];

// Execute and show results
echo "Class 10 General Student Result:\n";
foreach ($studentSubjectsGeneral as $subject => $marks) {
    $fail = isSubjectFailedClass10($subject, $studentSubjectsGeneral, 'general');
    echo $subject . ": " . ($fail ? 'Fail' : 'Pass') . "\n";
}

echo "\n";

// Example for Vocational
$studentSubjectsVocational = [
    'ICT' => ['written' => 25, 'mcq' => 5, 'practical' => 15, 'total' => 45],
    'Physics-1' => ['written' => 9, 'mcq' => 8, 'practical' => 8, 'total' => 25],
    'Chemistry-1' => ['written' => 12, 'mcq' => 8, 'practical' => 8, 'total' => 28],
    'Bangla' => ['written' => 22, 'mcq' => 9, 'practical' => 0, 'total' => 31],
];

echo "Class 10 Vocational Student Result:\n";
foreach ($studentSubjectsVocational as $subject => $marks) {
    $fail = isSubjectFailedClass10($subject, $studentSubjectsVocational, 'vocational');
    echo $subject . ": " . ($fail ? 'Fail' : 'Pass') . "\n";
}