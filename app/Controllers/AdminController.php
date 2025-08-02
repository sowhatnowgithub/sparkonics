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
    public function BackUp()
    {
        $this->sessionStatusCord("Backing up the data");
        $url = Env::BASE_PATH;
        require Env::BASE_PATH . "/app/Views/backupData.php";
    }
    public function sessionStatus($content)
    {
        session_start();

        $timeout = 60 * 60 * 24 * 10;

        $trueCredentials = $this->adminModel->AuthenticateData();
        $value = $trueCredentials[$_SESSION["usermobile"]];
        if (isset($value)) {
            if ($value["MemAccessGranted"] == 0) {
                header("Location: {$this->url}/admin/");
                exit();
            }
            if ($value["MemPosition"] != $_SESSION["userposition"]) {
                header("Location: {$this->url}/admin/");
                exit();
            }
            if ($value["MemId"] != $_SESSION["userid"]) {
                header("Location: {$this->url}/admin/");
                exit();
            }
        }
        $logFilePath = Env::BASE_PATH . "/app/Views/logs/user.log";

        $logData =
            "User Id : {$_SESSION["userid"]} " .
            date("Y-m-d H:i:s") .
            " " .
            "UserMobile : {$_SESSION["usermobile"]} " .
            "UserPosition : {$value["MemPosition"]} " .
            "UserName : {$_SESSION["usermail"]} " .
            "Content : $content \n";

        $value = null;
        file_put_contents($logFilePath, $logData, FILE_APPEND);

        if (
            isset($_SESSION["last_activity"]) &&
            time() - $_SESSION["last_activity"] > $timeout
        ) {
            $this->Logout();
        }

        $_SESSION["last_activity"] = time();
        if (
            !isset($_SESSION["usermobile"]) ||
            !isset($_SESSION["usermail"]) ||
            !isset($_SESSION["authenticated"])
        ) {
            header("Location: {$this->url}/admin/");
            exit();
        }
    }
    public function sessionStatusCord($data)
    {
        $this->sessionStatus($data);
        if (
            isset($_SESSION["auth_cookie_cord"]) &&
            $_SESSION["userposition"] === "Coordinator"
        ) {
            if (
                $this->validateAuthCookie(
                    $_SESSION["usermobile"],
                    $_SESSION["auth_cookie_cord"],
                )
            ) {
                return true;
            } else {
                header("Location: {$this->uri}/admin/home");
                exit();
            }
        } else {
            require Env::BASE_PATH . "/app/Views/Error.php";
            exit();
        }
    }

    protected function createAuthCookie($usermobile)
    {
        require "Authenticate.php";
        $hash_value = hash_hmac("sha256", $usermobile, $key, true);
        return $hash_value;
    }
    protected function validateAuthCookie($usermobile, $hash)
    {
        require "Authenticate.php";
        $recalculated_hash = hash_hmac("sha256", $usermobile, $key, true);

        if ($hash === $recalculated_hash) {
            return true;
        }
        return false;
    }
    public function Authenticate($credentials)
    {
        $trueCredentials = $this->adminModel->AuthenticateData();

        $value = $trueCredentials[$credentials["usermobile"]];
        if (isset($value)) {
            $trueCredentials = $value;
            $value = null;
        } else {
            header("Location: {$this->url}/admin/");
            exit();
        }
        if (
            $trueCredentials["MemMobile"] === $credentials["usermobile"] &&
            $trueCredentials["MemPassword"] === $credentials["userpassword"] &&
            $trueCredentials["MemWebMail"] === $credentials["usermail"] &&
            $trueCredentials["MemPosition"] == $credentials["userposition"]
        ) {
            if ($trueCredentials["MemAccessGranted"] == "1") {
                session_start();
                session_regenerate_id(true);
                $_SESSION["userid"] = $trueCredentials["MemId"];
                $_SESSION["usermobile"] = $trueCredentials["MemMobile"];
                $_SESSION["usermail"] = $trueCredentials["MemWebMail"];
                $_SESSION["userposition"] = $trueCredentials["MemPosition"];
                $_SESSION["authenticated"] = true;
                if ($credentials["userposition"] === "Coordinator") {
                    $_SESSION["auth_cookie_cord"] = $this->createAuthCookie(
                        trim($credentials["usermobile"]),
                    );
                }
                header("Location: {$this->url}/admin/home");
                exit();
            } else {
                header("Location: {$this->url}/admin/");
                exit();
            }
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
        $this->sessionStatus("Using the Home page");
        require Env::BASE_PATH . "/app/Views/Home.php";
    }
    public function WebsiteControl()
    {
        $this->sessionStatus("Accesing the WebSite Controller Page");
        require Env::BASE_PATH . "/app/Views/WebsiteControl.php";
    }
    public function GetForm($formData)
    {
        $this->sessionStatus(
            "Fetching the form for website control" . json_encode($formData),
        );

        $section = $formData["section"];
        $action = $formData["action"];
        $formControlData = $this->adminModel->AdminFormControl(
            $section,
            $action,
        );

        require Env::BASE_PATH . "/app/Views/FormControlApi.php";
    }
    public function ApiHandler($formData)
    {
        $this->sessionStatus(
            "Accesing The Api Control with settings : " .
                json_encode($formData),
        );
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
        $this->sessionStatusCord("Accessing the Log Files");
        require Env::BASE_PATH . "/app/Views/Log.php";
    }

    public function Dashboard()
    {
        $this->sessionStatus("Accesing the Dashboard");
        $memberData = $this->adminModel->FetchMember($_SESSION["userid"]);
        $url = Env::HOST_ADDRESS;
        require Env::BASE_PATH . "/app/Views/Dashboard.php";
    }
}
