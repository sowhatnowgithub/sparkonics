<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Models\AdminModel;
use Sowhatnow\Env;
class AdminController
{
    protected $url = Env::HOST_ADDRESS;
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        ini_set("session.use_only_cookies", 1);
        ini_set("session.cookie_httponly", 1);
        session_set_cookie_params([
            "lifetime" => 60 * 60 * 24 * 10,
            "path" => "/",
            "secure" => false,
            "httponly" => true,
            "samesite" => "Strict",
        ]);
    }
    public function sessionStatus()
    {
        session_start();
        $timeout = 60 * 60 * 24 * 10;

        if (
            isset($_SESSION["last_activity"]) &&
            time() - $_SESSION["last_activity"] > $timeout
        ) {
            $this->Logout();
        }

        $_SESSION["last_activity"] = time();
        if (
            !isset($_SESSION["username"]) ||
            !isset($_SESSION["usermail"]) ||
            !isset($_SESSION["authenticated"])
        ) {
            header("Location: {$this->url}/admin/");
            exit();
        }
    }
    public function sessionStatusCord()
    {
        $this->sessionStatus();
        if (
            isset($_SESSION["auth_cookie_cord"]) &&
            $_SESSION["userrole"] === "cord"
        ) {
            if (
                $this->validateAuthCookie(
                    $_SESSION["username"],
                    $_SESSION["auth_cookie_cord"]
                )
            ) {
                return true;
            } else {
                header("Location: {$this->uri}/admin/home");
                exit();
            }
        } else {
            echo "Don't have access to this since not cord";
            exit();
        }
    }

    protected function createAuthCookie($username)
    {
        require "Authenticate.php";
        $hash_value = hash_hmac("sha256", $username, $key, true);
        return $hash_value;
    }
    protected function validateAuthCookie($username, $hash)
    {
        require "Authenticate.php";
        $recalculated_hash = hash_hmac("sha256", $username, $key, true);

        if ($hash === $recalculated_hash) {
            return true;
        }
        return false;
    }
    public function Authenticate($credentials)
    {
        $trueCredentials = $this->adminModel->AuthenticateData();

        if (
            $trueCredentials["User"] === $credentials["username"] &&
            $trueCredentials["Password"] === $credentials["password"] &&
            $trueCredentials["Mail"] === $credentials["usermail"] &&
            $trueCredentials["Role"] == $credentials["userrole"]
        ) {
            session_start();
            session_regenerate_id(true);
            $_SESSION["username"] = $credentials["username"];
            $_SESSION["usermail"] = $credentials["usermail"];
            $_SESSION["userrole"] = $credentials["userrole"];
            $_SESSION["authenticated"] = true;
            if ($credentials["userrole"] === "cord") {
                $_SESSION["auth_cookie_cord"] = $this->createAuthCookie(
                    trim($credentials["username"])
                );
            }
            header("Location: {$this->url}/admin/home");
            exit();
        } else {
            header("Location: {$this->url}/admin/");
            exit();
        }
    }
    public function index()
    {
        require Env::BASE_PATH . "/app/Views/Login.html";
    }
    public function Home()
    {
        $this->sessionStatus();
        require Env::BASE_PATH . "/app/Views/Home.php";
    }
    public function WebsiteControl()
    {
        $this->sessionStatus();
        require Env::BASE_PATH . "/app/Views/WebsiteControl.php";
    }
    public function GetForm($formData)
    {
        $this->sessionStatus();

        $section = $formData["section"];
        $action = $formData["action"];
        $formControlData = $this->adminModel->AdminFormControl(
            $section,
            $action
        );

        require Env::BASE_PATH . "/app/Views/FormControl.php";
    }
    public function ApiHandler($formData)
    {
        $this->sessionStatus();
        require Env::BASE_PATH . "/app/Views/ApiControl.php";
    }
    public function Logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        setcookie(session_name(), "", time() - 3600, "/");
        header("Location: {$this->uri}/admin/");
        exit();
    }
    public function LogUser()
    {
        $this->sessionStatusCord();

        require Env::BASE_PATH . "/app/Views/Log.php";
    }
    public function Members()
    {
        $this->sessionStatusCord();
        require Env::BASE_PATH . "/app/Views/MembersControl.php";
    }
    public function Dashboard()
    {
        $this->sessionStatus();
        require Env::BASE_PATH . "/app/Views/Dashboard.php";
    }
}
