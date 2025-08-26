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
            return [
                'id'          => $event['id'],
                'title'       => $event['title'],
                'description' => $event['description'],
                'start'       => $event['start_date'],
                'start_time'  => $event['start_time'],
                'end'         => $event['end_date'],
                'end_time'    => $event['end_time'],
                'color'       => $event['color'],
                'category'    => $event['category'],
                'subcategory' => $event['subcategory'],
                'class'       => $event['class'],
                'subject'     => $event['subject']
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}
