<?php

namespace App\Controllers;

use App\Models\CalendarModel;
use CodeIgniter\Controller;

class PublicCalendar extends Controller
{
    public function index()
    {
        return view('public/calendar');
    }

    public function events()
    {
        $model = new CalendarModel();
        $events = $model->findAll();

        $data = array_map(function ($event) {
            $start = $event['start_date'] . (!empty($event['start_time']) ? 'T' . $event['start_time'] : '');
            $end   = $event['end_date'] . (!empty($event['end_time']) ? 'T' . $event['end_time'] : '');

            return [
                'id'    => $event['id'],
                'title' => $event['title'],
                'start' => $start,
                'end'   => $end,
                'color' => $event['color'],
                'extendedProps' => [
                    'description' => $event['description'],
                    'category'    => $event['category'],
                    'subcategory' => $event['subcategory'],
                    'class'       => $event['class'],
                    'subject'     => $event['subject'],
                ]
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}
