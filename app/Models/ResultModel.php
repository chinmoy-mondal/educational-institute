<?php

namespace App\Models;

use CodeIgniter\Model;

class ResultModel extends Model
{
	protected $table      = 'results';
	protected $primaryKey = 'id';

	protected $allowedFields = [
		'teacher_id',
		'student_id',
		'subject_id',
		'roll',
		'exam',
		'year',
		'class',        // ✅ newly added
		'written',
		'mcq',
		'practical',
		'total',
		'created_at',
		'updated_at',
		'publish',      // ✅ newly added
	];
	public $timestamps = false; // because we handle created_at/updated_at manually

	public function withSubject()
	{
		return $this->select('results.*, subjects.subject')
			->join('subjects', 'subjects.id = results.subject_id');
	}
}
