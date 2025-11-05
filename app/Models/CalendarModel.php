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
        'start_time',
        'end_date',
        'end_time',
        'color',
        'class',
        'category',
        'subcategory',
        'subject'
    ];
}