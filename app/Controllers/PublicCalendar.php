<?php

namespace App\Controllers;

use App\Models\CalendarModel;
use App\Models\SubjectModel;
use CodeIgniter\Controller;

class PublicCalendar extends Controller
{
    public function index()
    {
        return view('public/calendar');
    }

    public function events()
    {
        $calendarModel = new CalendarModel();
        $subjectModel  = new SubjectModel();

        $events = $calendarModel->findAll();

        $data = array_map(function ($event) use ($subjectModel) {
            // Build proper start and end datetime strings
            $start = $event['start_date'] . (!empty($event['start_time']) ? 'T' . $event['start_time'] : '');
            $end   = $event['end_date'] . (!empty($event['end_time']) ? 'T' . $event['end_time'] : '');

            // ✅ Directly fetch subject name from the database
            $subjectName = '';
            if (!empty($event['subject'])) {
                $subject = $subjectModel->where('id', $event['subject'])->first();
                $subjectName = $subject['subject'] ?? '';
            }

            return [
                'id'    => $event['id'],
                'title' => $event['title'],
                'start' => $start,
                'end'   => $end,
                'color' => $event['color'],
                'extendedProps' => [
                    'description' => $event['description'] ?? '',
                    'category'    => $event['category'] ?? '',
                    'subcategory' => $event['subcategory'] ?? '',
                    'event_class' => $event['class'] ?? '',
                    'subject'     => $subjectName, // ✅ show subject name directly
                ]
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}
