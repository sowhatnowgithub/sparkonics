<?php

use Sowhatnow\Env;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function mailer($mailerInfo)
{
$mail = new PHPMailer(true);

try {
$mail->isSMTP();
$mail->Host = "smtp-mail.outlook.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = 587;

$mail->Username = $mailerInfo["SenderEmail"];
$mail->Password = $mailerInfo["SenderEmailPassword"];

$mail->setFrom($mailerInfo["SenderEmail"], "Sparkonics Mailer");
$mail->addAddress($mailerInfo["RecipientEmail"]);


$logoPath = Env::BASE_PATH . "/public/images/logo.png";
$mail->addEmbeddedImage($logoPath, "sparkonics_logo");

$footerHTML = <<<HTML
    <hr style="margin-top:20px;"/>
    <div style="text-align: center; font-size: 13px; color: #555;">
	<img src="cid:sparkonics_logo" alt="Sparkonics Logo" width="100" style="margin-bottom: 10px;"><br>
	<strong>Sparkonics</strong><br>
	Society of Electrical Engineers<br>
	Indian Institute of Technology Patna
    </div>
HTML;

$mail->isHTML(true);
$mail->Subject = $mailerInfo["Subject"];
$mail->Body = $mailerInfo["Body"] . $footerHTML;

$mail->send();
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
<meta charset='UTF-8'>
<meta name='viewport' content='width=device-width, initial-scale=1.0'>
<meta http-equiv='X-UA-Compatible' content='ie=edge'>
<title>Mail Verification</title>
<style>
body {
font-family: Arial, sans-serif;
background-color: #f4f4f4;
display: flex;
justify-content: center;
align-items: center;
height: 100vh;
margin: 0;
}

.emailmessage {
background-color: #e0f7fa;
color: #00796b;
padding: 20px 30px;
border-radius: 8px;
box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
font-size: 16px;
}
</style>
</head>
<body>

<div class='emailmessage'>Email sent to {$mailerInfo['RecipientEmail']} Please check your mail</div>

</body>
</html>

";
$mail = null;
} catch (Exception $e) {
echo "Mailer Error: {$e}\n";
echo "<br>";
echo "<a href='/client/'>Go Back</a>";
}
}

$body = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .email-header h1 {
            color: #00796b;
        }
        .email-message {
            font-size: 16px;
            line-height: 1.5;
        }
        .verification-code {
            display: inline-block;
            padding: 10px;
            font-size: 18px;
            background-color: #00796b;
            color: white;
            border-radius: 5px;
            font-weight: bold;
        }
        .verification-link {
            display: block;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #00796b;
            text-decoration: none;
            padding: 10px;
            background-color: #e0f7fa;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='email-header'>
            <h1>Email Verification</h1>
        </div>
        
        <div class='email-message'>
            <p>Hello,</p>
            <p>Thank you for registering with us! To complete your registration, please verify your email address by entering the verification code below:</p>
            <p class='verification-code'>$mailHash</p>
            <a href='https://sparkonics.iitp.ac.in/client/verifyclient' class='verification-link'>Click here to Verify Your Email</a>

            <p>Once you enter the code, you will be successfully verified.</p>
            <p>If you did not request this verification, please ignore this email.</p>
        </div>

        <div class='footer'>
            <p>&copy; 2025 Your Company Name</p>
        </div>
    </div>
</body>
</html>

";
$mailerInfo = ["SenderEmail" => "lakshmi_2302cm05@iitp.ac.in",
	"SenderEmailPassword" => "Jp05101974@",
	"RecipientEmail" => "{$settings['usermail']}",
	"Subject" => "Email Verification for sparkonics website",
	"Body" => $body	
];


mailer($mailerInfo);
