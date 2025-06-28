<!-- Admin Panel-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>AdminPanelX</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        padding: 20px;
        background-color: #f5f5f5;
      }
      form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        max-width: 500px;
        margin: auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }
      label {
        display: block;
        margin: 15px 0 5px;
        font-weight: bold;
      }
      input[type="text"],
      input[type="datetime-local"],
      input[type="url"],
      textarea {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
      }
      input[type="submit"] {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
<?php
$baseUrl = Sowhatnow\Env::API_BASE_URL . "{$formControlData["action_url"]}";
$data = "<form method='POST' action='apicontrol' >";
$data .= "<h2>$section $action</h2>";
foreach ($formControlData["FormData"] as $FormName => $setting) {
    $data .= "<label for='{$FormName}'>$FormName</label>";
    if ($setting[1] == "textarea") {
        $data .= "<textarea rows='5' id='{$FormName}' name='{$FormName}' type='{$setting[1]}' placeholder='{$setting[2]}' {$setting[0]} ></textarea>";
    } else {
        $data .= "<input id='{$FormName}' name='{$FormName}'  type='{$setting[1]}' placeholder='{$setting[2]}' {$setting[0]}  />";
    }
}

$data .= "<input type='hidden' name='method' value='{$formControlData["request_method"]}'/>";
$data .= "<input type='hidden' name='action' value='{$action}'/>";
$data .= "<input type='hidden' name='baseUrl' value='{$baseUrl}'/>";
$data .= "<input type='submit'/>";
$data .= "</form>";
echo $data;
?>
</body>
</html>
