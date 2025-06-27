<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Models\AdminModel;

class AdminController
{
    protected $adminModel;
    public const apiBaseUrl = "http://localhost:1978";
    public function __construct()
    {
        $this->adminModel = new AdminModel();
    }
    public function index()
    {
        require "/Users/pavan/Desktop/Current_projects/sparkonics/app/Views/AdminLogin.php";
    }
    public function Authenticate($credentials)
    {
        $trueCredentials = $this->adminModel->AuthenticateData();
        if ($trueCredentials["User"] === $credentials["username"]) {
            if ($trueCredentials["Password"] === $credentials["password"]) {
                require "/Users/pavan/Desktop/Current_projects/sparkonics/app/Views/AdminPanel.php";
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
        require "/Users/pavan/Desktop/Current_projects/sparkonics/app/Views/AdminControl.php";
    }
}
