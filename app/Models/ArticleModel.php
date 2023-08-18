<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = "article";

    protected $allowedFields = ["title", "content"];

    protected $returnType = \App\Entities\Article::class;

    protected $validationRules = [
        "title" => "required|max_length[128]",
        "content" => "required"
    ];

    protected $validationMessages = [
        "title" => [
            "required" => "Please enter a title",
            "max_length" => "{param} maximum characters for the {field}"
        ]
    ];

    protected $beforeInsert = ["setUsersID"];

    protected $useTimestamps = true;

    protected function setUsersID(array $data)
    {
        $data["data"]["users_id"] = auth()->user()->id;

        return $data;
    }
}