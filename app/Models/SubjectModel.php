<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
    protected $table = 'subjects';
    protected $allowedFields = ['class', 'section', 'subject', 'full_mark'];
}
