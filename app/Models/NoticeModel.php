<?php

namespace App\Models;
use CodeIgniter\Model;

class NoticeModel extends Model
{
    protected $table = 'notices';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'body',
        'notice_date',
        'document_url',
        'created_at'
    ];
}