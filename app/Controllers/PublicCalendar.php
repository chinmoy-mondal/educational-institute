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
            // Combine date and time
            $start = $event['start_date'];
            if (!empty($event['start_time'])) {
                $start .= 'T' . $event['start_time'];
            }

            $end = $event['end_date'];
            if (!empty($event['end_time'])) {
                $end .= 'T' . $event['end_time'];
            }

            return [
                'id'          => $event['id'],
                'title'       => $event['title'],
                'description' => $event['description'],
                'start'       => $start,
                'end'         => $end,
                'color'       => $event['color'],
                'category'    => $event['category'],
                'subcategory' => $event['subcategory'],
                'class'       => $event['class'],
                'subject'     => 'bang'
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}
