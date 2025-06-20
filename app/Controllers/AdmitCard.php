<?php


namespace App\Controllers;

use App\Libraries\PdfGenerator;

class AdmitCard extends BaseController
{
    public function print()
    {
        $students = [
            [
                'name' => 'MD JEHAD HASAN ROBI',
                'roll' => 23,
                'class' => 'Six',
                'exams' => [
                    ['subject' => 'Math', 'date' => '2025-07-01', 'time' => '10:00 AM'],
                    ['subject' => 'English', 'date' => '2025-07-03', 'time' => '10:00 AM'],
                ]
            ],
            [
                'name' => 'MD RIFAT HOSSEN NIEEM',
                'roll' => 62,
                'class' => 'Six',
                'exams' => [
                    ['subject' => 'Math', 'date' => '2025-07-01', 'time' => '10:00 AM'],
                    ['subject' => 'English', 'date' => '2025-07-03', 'time' => '10:00 AM'],
                ]
            ],
            // Add more students here
        ];

        $pdf = new PdfGenerator();
        $html = view('pdf/admit_cards', ['students' => $students]);
        $pdf->generate($html, 'admit_cards.pdf', true);
    }
}
