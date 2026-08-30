<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTasksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "null" => false,
                "auto_increment" => true
            ],
            "title" => [
                "type" => "VARCHAR",
                "constraint" => 128,
                "null" => false
            ],
            "description" => [
                "type" => "TEXT",
                "null" => true
            ],
            "status" => [
                "type" => "ENUM",
                "constraint" => ["pendente", "em andamento", "concluída"],
                "default" => "pendente"
            ]
        ]);

        $this->forge->addPrimaryKey("id");

        $this->forge->createTable("tasks");
    }

    public function down()
    {
        $this->forge->dropTable("tasks");
    }
}
