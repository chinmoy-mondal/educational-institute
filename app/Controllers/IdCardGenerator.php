<?php

namespace App\Controllers;

use App\Models\StudentModel;
use CodeIgniter\Controller;
use Endroid\QrCode\Builder\Builder;
use Intervention\Image\ImageManagerStatic as Image;

class IdCardGenerator extends Controller
{
    public function generate()
    {
        $studentModel = new StudentModel();
        $students = $studentModel->findAll();

        $outputDir = WRITEPATH . 'idcards/';
        if (!is_dir($outputDir)) mkdir($outputDir, 0777, true);

        foreach ($students as $student) {
            $qrData = json_encode([
                'name'     => $student['student_name'],
                'roll'     => $student['roll'],
                'class'    => $student['class'],
                'section'  => $student['section'],
                'phone'    => $student['phone']
            ]);

            // Generate QR Code
            $qr = Builder::create()
                ->data($qrData)
                ->size(150)
                ->margin(10)
                ->build();
            $qrPath = $outputDir . 'qr_' . $student['id'] . '.png';
            file_put_contents($qrPath, $qr->getString());

            // Create ID Card base
            $card = Image::canvas(600, 350, '#ffffff');

            // Draw photo
            $photoPath = FCPATH . 'uploads/' . ($student['student_pic'] ?? 'default.png');
            if (!file_exists($photoPath)) $photoPath = FCPATH . 'public/assets/img/default.png';
            $photo = Image::make($photoPath)->fit(100, 100);
            $card->insert($photo, 'top-left', 30, 30);

            // Insert QR code
            $qrImg = Image::make($qrPath);
            $card->insert($qrImg, 'top-right', 30, 30);

            // Add student info
            $card->text('Name: ' . $student['student_name'], 150, 40, function($font) {
                $font->file(FCPATH . 'public/fonts/arial.ttf');
                $font->size(20);
                $font->color('#000000');
            });
            $card->text('Class: ' . $student['class'] . ' | Roll: ' . $student['roll'], 150, 80, function($font) {
                $font->file(FCPATH . 'public/fonts/arial.ttf');
                $font->size(18);
                $font->color('#000000');
            });
            $card->text('Section: ' . $student['section'], 150, 115, function($font) {
                $font->file(FCPATH . 'public/fonts/arial.ttf');
                $font->size(18);
                $font->color('#000000');
            });

            // Save final card
            $cardPath = $outputDir . 'idcard_' . $student['id'] . '.jpg';
            $card->save($cardPath, 90);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => count($students) . ' ID cards generated.',
            'folder' => str_replace(FCPATH, base_url('/'), $outputDir)
        ]);
    }
}
