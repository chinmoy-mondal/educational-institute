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
		'picture',
		'assagin_sub',
		'account_status',
		'permit_by',
		'blood_group',
		'index_number',
		'dob',
		'joining_date',
		'religion',
		'mpo_date',
		'bio'
	];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
}
