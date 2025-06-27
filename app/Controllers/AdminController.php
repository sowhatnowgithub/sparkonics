<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Models\User;

class AdminController
{
    public function index()
    {
        $userModel = new AdminModel();
        $users = $userModel->getAll();
        require __DIR__ . "/../Views/users.php";
    }
    public function test()
    {
        echo __NAMESPACE__;
    }
}
