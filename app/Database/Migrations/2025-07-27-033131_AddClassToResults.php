<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassToResults extends Migration
{
	public function up()
	{
		$this->forge->addColumn('results', [
				'class' => [
				'type'       => 'TINYINT',
				'constraint' => 2,
				'null'       => true,
				'after'      => 'year',
				],
				'publish' => [
				'type'       => 'TINYINT',
				'constraint' => 1,
				'null'       => false,
				'default'    => 0,
				'after'      => 'class',
				],
		]);
	}
	public function down()
	{
		$this->forge->dropColumn('results', ['class', 'publish']);
	}
}
