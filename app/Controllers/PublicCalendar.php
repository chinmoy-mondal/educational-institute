<?php

namespace App\Controllers;

use App\Models\CalendarModel;
use CodeIgniter\Controller;

class PublicCalendar extends Controller
{
    public function index()
    {
        return view('public_calendar');
    }

    public function events()
    {
        $model = new CalendarModel();
        $events = $model->findAll();

        $data = array_map(function ($event) {
            return [
                'id'    => $event['id'],
                'title' => $event['title'],
                'start' => $event['start_date'],
                'end'   => date('Y-m-d', strtotime($event['end_date'] . ' +1 day')),
                'color' => $event['color'],
                'description' => $event['description']
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}
