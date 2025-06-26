<?php

namespace App\Models;

use CodeIgniter\Model;

class SubjectModel extends Model
{
	protected $table      = 'subjects';
	protected $primaryKey = 'id';

	// pick the columns you really need to protect/allow
	protected $allowedFields = ['class', 'section', 'subject'];
}
