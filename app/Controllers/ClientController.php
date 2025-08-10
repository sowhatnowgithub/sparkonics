<?php
namespace Sowhatnow\App\Controllers;
use Sowhatnow\App\Models\ClientModel;
use Sowhatnow\Env;
class ClientController 
{
    protected $url = Env::HOST_ADDRESS;
    protected $clientModel;
    public function __construct()
    {
        $this->clientModel = new ClientModel();
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
    protected function createAuthCookie($usermobile)
    {
        require "Authenticate.php";
        $hash_value = hash_hmac("sha256", $usermobile, $key, true);
	$hash_value = base64_encode($hash_value);
       return $hash_value;
    }
    protected function validateAuthCookie($usermobile, $hash)
    {
        require "Authenticate.php";
        $recalculated_hash = hash_hmac("sha256", $usermobile, $key, true);

	$recalculated_hash = base64_encode($recalculated_hash);
        if ($hash == $recalculated_hash) {
            return true;
        }
        return false;
    }

    public function Login()
    {
        require_once Env::BASE_PATH . "/app/Views/ClientLogin.php";
    }
    public function MailVerifyClient($settings) {
	    session_start();
	    foreach($settings as $setting => $value) {
	    	$_SESSION[$setting] = $value;
	    }
	    $_SESSION['verification_code']=$this->createAuthCookie($settings['userphone']);
	$mailHash  = $this->createAuthCookie($_SESSION['verification_code']);
	    $unlock =$this->validateAuthCookie($_SESSION['verification_code'],$mailHash);
           require Env::BASE_PATH . "/app/Views/SendEmailVerify.php";
    }

	public function Clientverify() {
           require Env::BASE_PATH . "/app/Views/ClientVerify.php";
	}
    public function RegisterClient($settings)
    {
	session_start();

	$unlock =$this->validateAuthCookie($_SESSION['verification_code'],$settings['verification_code']);
if($unlock) {
        $query = "INSERT INTO Clients (ClientName,
        ClientWebMail ,
        ClientMobile ,
        ClientDegree ,
        ClientRollNo ,
        ClientPassword
        ) VALUES ( ";
        $query .= "'{$_SESSION["username"]}'";
        $query .= ",";
        $query .= "'{$_SESSION["usermail"]}'";
        $query .= ",";
        $query .= "'{$_SESSION["userphone"]}'";
        $query .= ",";

        $query .= "'{$_SESSION["userdepartment"]}'";
        $query .= ",";

        $query .= "'{$_SESSION["userrollnumber"]}'";
        $query .= ",";

        $query .= "'{$_SESSION["userpassword"]}'";

        $query .= " )";
        $response = $this->clientModel->RegisterClient($query);
        if ($response) {
	$_SESSION = []; 
	echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">✅</div>
  <h1>Registration Successful!</h1>
  <p>Your account has been created and verified successfully.</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


';
            exit();
        } else {

		echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Registration Failed!</h1>
<p>Please enter correct verification code</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


';
            exit();
        }
} else {
		echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Registration Failed!</h1>
<p>Please enter correct verification code</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


';
exit();
}
    }
    public function GetClients() {
	/*Falied to implement, due to security leakage of client details */
	    $controller = new AdminController;
	    $controller->sessionStatus("Accesing the clients list");
	    $data = $this->clientModel->GetClients();
	    echo json_encode($data);
    }
    public function ClientControl() {
    
	    $controller = new AdminController;
	    $controller->sessionStatus("Accesing the clients list");
	require Env::BASE_PATH."/app/Views/ClientControl.php";

    }
    public function DeleteClient($data)
    {

	    $controller = new AdminController;
	    $controller->sessionStatus("Accesing the clients list");
        echo $this->clientModel->DeleteClient($data["ClientId"]);
    }

public function ClientAuthenticate($settings) {
    $response =  $this->clientModel->GetClients();
    $ourclient = [];
    foreach($response as $client) {
	    if($client['ClientMobile'] == $settings['usermobile']) {
		    $ourclient = $client;
		    break;
	    }
    }
    if($ourclient != null){
    if( $ourclient['ClientWebMail'] == $settings['usermail'])  { 
   	 if( $ourclient['ClientPassword'] == $settings['userpassword'])  { 
   		session_start();
	       $_SESSION['client_session_id'] = $this->createAuthCookie($settings['usermobile']);
		$_SESSION['client_mobile'] = $settings['usermobile'];
		$_SESSION['client_id'] = $ourclient['ClientId'];
		header('Location: https://sparkonics.iitp.ac.in/client/home');
    } else {
    		echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Login Failed!</h1>
<p>Please enter correct Password</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


'; } 
    } else {
    		echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Login Failed!</h1>
<p>Please enter correct WebMail</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


'; }
    }else {
    		echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Login Failed!</h1>
<p>Please enter correct Mobile Number</p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>


'; }
}

public function ClientSessionStatus() {
	session_start();
	if($_SESSION['client_session_id'] != null && $_SESSION['client_mobile'] != null  ) {
		$response = $this->validateAuthCookie($_SESSION['client_session_id'], $_SESSION['client_mobile' ]);	
	return true;
	} return false;
}
public function ClientHome() {
	$response = true;
	if($response) 
	require Env::BASE_PATH."/app/Views/ClientHome.php";
	else {
			echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Authentication Failed!</h1>
<p>Please Login </p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>
';
	}
}
public function ClientDashboard() {
	$dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
		$response = $this->ClientSessionStatus();
	if($response) 
	require Env::BASE_PATH."/app/Views/ClientDashboard.php";
	else {
			echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Authentication Failed!</h1>
<p>Please Login </p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>
';
	}
}







public function ClientsLeaderBoard() {
	$dbPath = Env::BASE_PATH . "/app/Models/Database/clients.db";
	if($response) 
	require Env::BASE_PATH."/app/Views/ClientLeaderboard.php";
	else {
			echo '
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registration Successful</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background: #f2f8f7;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .container {
      background: white;
      padding: 30px 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      text-align: center;
    }

    .success-icon {
      font-size: 60px;
      color: #2ecc71;
    }

    h1 {
      font-size: 24px;
      color: #333;
      margin: 20px 0 10px;
    }

    p {
      font-size: 16px;
      color: #666;
      margin-bottom: 25px;
    }

    .btn {
      display: inline-block;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      padding: 12px 25px;
      border-radius: 5px;
      font-size: 16px;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: #27ae60;
    }

    @media (max-width: 480px) {
      h1 {
        font-size: 20px;
      }

      .btn {
        padding: 10px 20px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="success-icon">‼️‼️</div>
  <h1>Authentication Failed!</h1>
<p>Please Login </p>
  <a href="/client/" class="btn">Go to Login</a>
</div>

</body>
</html>
';
	}
}
}

