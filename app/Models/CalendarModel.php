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
        'start_time',    // added
        'end_date', 
        'end_time',      // added
        'color', 
        'category',
        'subcategory',
        'class',
        'subject'
    ];
}