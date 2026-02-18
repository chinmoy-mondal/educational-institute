<?php

namespace App\Models;

use CodeIgniter\Model;

class WelcomeMessageModel extends Model
{
    protected $table            = 'welcome_message';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'title',
        'photo',
        'message',
        'status',      // ✅ added
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}