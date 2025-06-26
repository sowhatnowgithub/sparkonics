<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Models\User;

class UserController {
	public function index() {
		$userModel = new User();
		$users = $userModel->getAll();
		require __DIR__ . '/../Views/users.php';
	}
	public function test() {
		echo __NAMESPACE__;
	}	
}
