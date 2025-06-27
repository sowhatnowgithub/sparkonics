<?php

namespace Sowhatnow\App\Models;

class AdminModel
{
    public function AuthenticateData()
    {
        $data = json_decode(
            file_get_contents(
                "/Users/pavan/Desktop/Current_projects/sparkonics/app/Models/Database/credentials.json"
            ),
            1
        );
        return $data;
    }
    public function AdminFormControl($section, $action)
    {
        $formData = json_decode(
            file_get_contents(
                "/Users/pavan/Desktop/Current_projects/sparkonics/app/Models/Database/AdminFormControl.json"
            ),
            1
        );
        return $formData[$section][$action];
    }
}
