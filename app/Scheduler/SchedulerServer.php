<?php
/*
The emailer will be programmed to send mails to everyone that is subcords and cords to domains,
thats it, if he has to mail some custom then he has to give the email address specifically,


We have an Events db, which we will automatically take and send reminders before the registration and
before the event start

How it will work this, there will be a sqlite db, with fields like
Job details DB -> this will basically have details about the mail and all, what to send,
Job Id,
JobTo,
JobFrom,
JobSubject,
JobCc,
JobContent,
Task Id -> foriegnkey

Task Db => this will tell how the job should be executed, lets say at what date we have to start the mail sending,
And how many intervals we have to send the date, like every three days or every week like that,
And also deadline meaning how many days before a deadline we have to send, start date, and intervals for this too, and again,
TaskId,
JobId => foreign key
CreatedDate,DATE: DD-MM-YYYY
DeadLineDate,DATE: DD-MM-YYYY
DaysBeforeDeadLine, Days Integer
SendDate, DATE: DD-MM-YYYY
IntervalAfterSendDate, Indays

finally using the following DB

$jobTableQuery = "CREATE TABLE Jobs (
    JobId INTEGER PRIMARY KEY,
    RecipientEmail TEXT NOT NULL,
    SenderEmail TEXT NOT NULL,
    SenderEmailPassword TEXT NOT NULL,
    Subject TEXT NOT NULL,
    CC TEXT,
    Body TEXT NOT NULL,
    IsEventMail TEXT NOT NULL,
    StartDate TEXT NOT NULL,
    EndDate TEXT NOT NULL,
    IntervalDays INTEGER,
    NextScheduledAt TEXT,
    MaxOccurrences INTEGER,
    Active BOOLEAN DEFAULT 1
)";


*/
require_once __DIR__ . "/../../vendor/autoload.php";

use Swoole\Event;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$sleep = 60 * 1000 * 1000;
//this is in milli seconds, i am thinking
//It will be like a timer which will sleep for about 30minutes but for testing i will take 3seconds,
date_default_timezone_set("Asia/Kolkata");

function resheduleTheJob($executeDate, $job, $db)
{
    mailer($job);
    $max = 3;
    if (is_numeric($job["MaxOccurrences"])) {
        $max = (int) $job["MaxOccurrences"] - 1;
    }
    if ($max == 0) {
        $stmt = $db->prepare(
            "UPDATE Jobs SET MaxOccurrences = :max ,Active = 0 WHERE JobId = :id",
        );
        $stmt->execute([
            ":max" => $max,
            ":id" => $job["JobId"],
        ]);
    }
    if (is_numeric($job["IntervalDays"]) && $job["IntervalDays"] > 0) {
        $executeDate += (int) ((float) $job["IntervalDays"] * 86400);
        $executeDateNotUnix = date("Y-m-d\TH:i", $executeDate);
        $stmt = $db->prepare(
            "UPDATE Jobs SET MaxOccurrences = :max, NextScheduledAt = :next WHERE JobId = :id",
        );
        $stmt->execute([
            ":max" => $max,
            ":next" => $executeDateNotUnix,
            ":id" => $job["JobId"],
        ]);
    } else {
        $stmt = $db->prepare(
            "UPDATE Jobs SET MaxOccurrences = :max, NextScheduledAt = :next WHERE JobId = :id",
        );
        $stmt->execute([
            ":next" => $job["EndDate"],
            ":id" => $job["JobId"],
        ]);
    }
}
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

        if (!empty($mailerInfo["CC"])) {
            $ccAddresses = explode(",", $mailerInfo["CC"]);
            foreach ($ccAddresses as $cc) {
                $mail->addCC(trim($cc));
            }
        }

        $logoPath = __DIR__ . "/sparkonics_cover.jpeg";
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
        echo "Email sent to {$mailerInfo["RecipientEmail"]}\n";
        $mail = null;
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}\n";
    }
}

while(true){
    $now = date("Y-m-d\TH:i");
    $nowUnix = strtotime($now);
    echo "Now: $now\n";
    try {
        $dbPath =
            "/home/fac/sparkonics/public_html/app/Models/Database/Job.db";
        $db = new PDO("sqlite:$dbPath");
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $stmt = $db->prepare("SELECT * FROM Jobs");
        $stmt->execute();
        $jobs = $stmt->fetchAll();
        foreach ($jobs as $job) {
            $executeDate = strtotime($job["NextScheduledAt"]);
            $startDate = strtotime($job["StartDate"]);
            $endDate = strtotime($job["EndDate"]);
            $maxOccurances = $job["MaxOccurrences"];
            switch ($job["Active"]) {
                case 1:
                    if ($nowUnix > $endDate) {
                        $stmt = $db->prepare(
                            "DELETE FROM Jobs WHERE JobId = :id",
                        );
                        $stmt->execute([":id" => $job["JobId"]]);
                    } else {
                        switch ($executeDate) {
                            case false:
                                $stmt = $db->prepare(
                                    "UPDATE Jobs SET NextScheduledAt = '{$job["StartDate"]}' WHERE JobId = {$job["JobId"]}",
                                );
                                $stmt->execute();

                                if ($nowUnix >= strtotime($job["StartDate"])) {
                                    resheduleTheJob(
                                        strtotime($job["StartDate"]),
                                        $job,
                                        $db,
                                    );
                                }
                                break;
                            default:
                                if ($nowUnix >= $executeDate) {
                                    resheduleTheJob($executeDate, $job, $db);
                                }
                        }
                    }
                    break;
                case 0:
                    if ($nowUnix > $endDate) {
                        $stmt = $db->prepare(
                            "DELETE FROM Jobs WHERE JobId = :id",
                        );
                        $stmt->execute([":id" => $job["JobId"]]);
                    }
            }
        }
        $stmt = null;
        $db = null;
    } catch (\PDOException $e) {
        echo "Failed to fetch";
        var_dump($e);
    }
    usleep($sleep);
}
