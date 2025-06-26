<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ImportSubjectsSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        $events = $db->table('events')->get()->getResultArray();

        $subjects = [];

        foreach ($events as $event) {
            $class = trim($event['title']);
            $subject = trim($event['description']);

            // Determine section
            if (stripos($class, '(voc)') !== false) {
                $section = 'Vocational';
                $class = str_ireplace('(voc)', '', $class);
                $class = trim($class);
            } else {
                $section = 'General';
            }

            // Avoid inserting empty class or subject
            if ($class !== '' && $subject !== '') {
                $subjects[] = [
                    'class'      => $class,
                    'subject'    => $subject,
                    'section'    => $section,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
        }

        if (!empty($subjects)) {
            $db->table('subjects')->insertBatch($subjects);
        }
    }
}
