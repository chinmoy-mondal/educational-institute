<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table      = 'users';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'name',
		'role',
		'designation',
		'subject',
		'gender',
		'phone',
		'email',
		'password',
		'assagin_sub',  // <- match this with your DB column name
		'account_status',
		'permit_by',
		'created_at',
		'updated_at'
	];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
}
