<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToArticleTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn("article", [
            "users_id" => [
                "type" => "INT",
                "null" => false,
                "unsigned" => true,
                "constraint" => 11
            ]
        ]);

        $sql = "SELECT id FROM users LIMIT 1";

        $result = $this->db->query($sql)->getResult();

        if ($result) {

            $sql = "UPDATE article SET users_id = {$result[0]->id}";

            $this->db->query($sql);

        }

        $this->forge->addForeignKey("users_id", "users", "id",
                                    "CASCADE", "CASCADE", "article_users_id_fk");
        $this->forge->processIndexes("article");
    }

    public function down()
    {
        $this->forge->dropForeignKey("article", "article_users_id_fk");
        $this->forge->dropColumn("article", "users_id");
    }
}
