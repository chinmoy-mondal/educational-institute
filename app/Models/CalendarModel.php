<?php
namespace App\Models;

use CodeIgniter\Model;

class CalendarModel extends Model
{
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'start_date',
        'end_date',
        'color',
        'class',
        'category',
        'subcategory',
        'subject',
        'start_time',
        'end_time'
    ];
}