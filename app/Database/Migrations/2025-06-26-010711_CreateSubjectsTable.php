<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubjectsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
				'id'         => ['type' => 'INT', 'auto_increment' => true],
				'class'      => ['type' => 'VARCHAR', 'constraint' => 50],
				'subject'    => ['type' => 'VARCHAR', 'constraint' => 100],
				'section'    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
				'created_at' => ['type' => 'DATETIME', 'null' => true],
				'updated_at' => ['type' => 'DATETIME', 'null' => true],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('subjects');    }

	public function down()
	{
		$this->forge->dropTable('subjects');
	}
}
