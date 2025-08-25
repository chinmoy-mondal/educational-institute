<?php

namespace App\Models;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 
        'description', 
        'start_date', 
        'end_date', 
        'color', 
        'category',        // new
        'subcategory',     // new
        'class'            // already exists
    ];
}
