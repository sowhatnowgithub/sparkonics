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
use Openswoole\Timer;
use Swoole\Event;

$sleep = 3000;
//this is in milli seconds, i am thinking
//It will be like a timer which will sleep for about 30minutes but for testing i will take 3seconds,
date_default_timezone_set("Asia/Kolkata");

// make the members automated mailing based on the members db, we have mailing three weeks before two weeks before one week before befoer registraiton and on the day,

function mailer($mailerInfo) {}
Timer::tick($sleep, function () {
    try {
        $dbPath =
            "/Users/pavan/Desktop/Current_projects/sparkonics/app/Models/Database/Job.db";
        $db = new PDO("sqlite:$dbPath");
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        $stmt = $db->prepare("SELECT * FROM Jobs");
        $stmt->execute();
        $jobs = $stmt->fetchAll();
        foreach ($jobs as $job) {
            echo $job["StartDate"] . "\n";
        }
    } catch (\PDOException $e) {
        echo "Failed to fetch";
        var_dump($e);
    }
});
Event::wait();
