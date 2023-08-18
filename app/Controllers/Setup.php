<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Setup extends BaseController
{
    public function index()
    {
        $migrations = \Config\Services::migrations();

        $migrations->setNamespace(null)->latest();

        $seeder = \Config\Database::seeder();

        $seeder->call("AddAdminAccount");

        echo "Done.";
    }
}
