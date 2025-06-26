<?php

namespace Sowhatnow\App\Models;

class User {
	public function getAll(){
		return [
			["name"=>"Alice", "email" => 'alice@example.com'],
	['name'=>"Bob", "email"=>"bob@example.com"]
		];
	}
}


