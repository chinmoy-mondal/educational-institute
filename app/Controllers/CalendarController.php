<?php

namespace App\Controllers;

use App\Models\CalendarModel;

class Calendar extends BaseController
{
    public function events()
    {
        $model = new CalendarModel();
        $events = $model->findAll();

        $data = array_map(function ($event) {
            return [
                'id'          => $event['id'],
                'title'       => $event['title'],
                'start'       => $event['start_date'],
                'end'         => $event['end_date'],
                'color'       => $event['color'],
                'description' => $event['description'],
                'subcategory' => $event['subcategory'],
                'subject' => $event['subject']
            ];
        }, $events);

        return $this->response->setJSON($data);
    }
}