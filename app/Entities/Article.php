<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Article extends Entity
{
    public function isOwner(): bool
    {
        return $this->users_id == auth()->user()->id;
    }
}