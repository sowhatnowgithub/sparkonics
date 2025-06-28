<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Models\AdminModel;
use Sowhatnow\Env;
class AdminController
{
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
    public function index()
    {
        require Env::BASE_PATH . "/app/Views/AdminLogin.php";
    }
    public function Authenticate($credentials)
    {
        $trueCredentials = $this->adminModel->AuthenticateData();
        if ($trueCredentials["User"] === $credentials["username"]) {
            if ($trueCredentials["Password"] === $credentials["password"]) {
                require Env::BASE_PATH . "/app/Views/AdminPanel.php";
            } else {
                echo "Authentication Failed";
            }
        } else {
            echo "Authentication Failed\n";
        }
    }
    public function GetForm($section, $action)
    {
        $formControlData = $this->adminModel->AdminFormControl(
            $section,
            $action
        );
        require Env::BASE_PATH . "/app/Views/AdminControl.php";
    }
    public function ApiHandler($formData)
    {
        require Env::BASE_PATH . "/app/Views/AdminApiControl.php";
    }
}
