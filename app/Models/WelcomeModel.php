<?php

namespace App\Models;

use CodeIgniter\Model;

class WelcomeModel extends Model
{
    protected $table = 'welcome_message';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'photo',
        'message',
        'created_at',
        'updated_at'
    ];
}
