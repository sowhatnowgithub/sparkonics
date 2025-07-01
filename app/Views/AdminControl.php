
<?php
$baseUrl = Sowhatnow\Env::API_BASE_URL . "{$formControlData["action_url"]}";
$hostAddress = Sowhatnow\Env::HOST_ADDRESS;
$data = "<form method='POST' action='$hostAddress/admin/apicontrol' >";
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
