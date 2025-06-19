<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
	public function up()
	{
	    $this->forge->addField([
		'id' => [
		    'type' => 'INT',
		    'auto_increment' => true
		],
		'title' => [
		    'type' => 'VARCHAR',
		    'constraint' => 255
		],
		'description' => [
		    'type' => 'TEXT',
		    'null' => true
		],
		'start_date' => [
		    'type' => 'DATE'
		],
		'end_date' => [
		    'type' => 'DATE'
		],
		'color' => [
		    'type' => 'VARCHAR',
		    'constraint' => 20,
		    'default' => '#007bff'
		]
	    ]);
	    $this->forge->addKey('id', true);
	    $this->forge->createTable('events');
	}

	public function down()
	{
	    $this->forge->dropTable('events');
	}
}
