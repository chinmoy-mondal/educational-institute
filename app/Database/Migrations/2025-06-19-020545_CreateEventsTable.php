<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'title' => [
				'type' => 'VARCHAR',
				'constraint' => '255',
			],
			'description' => [
				'type' => 'TEXT',
				'null' => true,
			],
			'category' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
			],
			'subcategory' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'class' => [
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => true,
			],
			'subject' => [
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => true,
			],
			'start_date' => [
				'type' => 'DATE',
			],
			'start_time' => [
				'type' => 'TIME',
				'null' => true,
			],
			'end_date' => [
				'type' => 'DATE',
			],
			'end_time' => [
				'type' => 'TIME',
				'null' => true,
			],
			'color' => [
				'type' => 'VARCHAR',
				'constraint' => '20',
				'default' => '#007bff',
			],
			'created_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
			'updated_at' => [
				'type' => 'DATETIME',
				'null' => true,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->createTable('events');
	}

	public function down()
	{
		$this->forge->dropTable('events');
	}
}
