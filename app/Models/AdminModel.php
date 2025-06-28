<?php

namespace Sowhatnow\App\Models;
use Sowhatnow\Env;
class AdminModel
{
    public function AuthenticateData()
    {
        $data = json_decode(
            file_get_contents(
                Env::BASE_PATH . "/app/Models/Database/credentials.json"
            ),
            1
        );
        return $data;
    }
    public function AdminFormControl($section, $action)
    {
        $formData = json_decode(
            file_get_contents(
                Env::BASE_PATH . "/app/Models/Database/AdminFormControl.json"
            ),
            1
        );
        return $formData[$section][$action];
    }
}
