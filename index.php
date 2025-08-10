<?php

// index.php

require_once "vendor/autoload.php";
use Sowhatnow\Routes\Router;
use Sowhatnow\Env;

require_once "enum.php";

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$method = $_SERVER["REQUEST_METHOD"];
$router = new Router();

// Admin Part
$router->get("/admin/home", ["AdminController", "Home"]);
$router->get("/admin/", ["AdminController", "index"]);
$router->get("/admin/members", ["MembersController", "MembersControl"]);
$router->get("/admin/dashboard", ["AdminController", "Dashboard"]);
$router->get("/admin/log", ["AdminController", "LogUser"]);
$router->get("/admin/backupdb", ["AdminController", "BackUp"]);
$router->get("/admin/logout", ["AdminController", "Logout"]);
$router->get("/admin/websitecontrol", ["AdminController", "WebsiteControl"]);
$router->get("/admin/scheduler", ["SchedulerController", "SchedulerPage"]);
$router->get("/admin/jobs", ["SchedulerController", "FetchAllJobs"]);
$router->get("/admin/client",["ClientController","ClientControl"]);
$router->get("/admin/quiz",["QuizController","QuizControl"]);
$router->get("/admin/quizquestion",["QuizController","QuizQuestionControl"]);

$router->post("/admin/register", ["MembersController", "RegisterMember"]);
$router->post("/admin/auth", ["AdminController", "Authenticate"]);
$router->post("/admin/apicontrol", ["AdminController", "ApiHandler"]);
$router->post("/admin/getform", ["AdminController", "GetForm"]);
$router->post("/admin/member/delete", ["MembersController", "MemberDelete"]);
$router->post("/admin/member/access", [
    "MembersController",
    "GrantAccessMemeber",
]);
$router->post("/admin/member/updaterole", [
    "MembersController",
    "UpdateMemberRole",
]);
$router->post("/admin/member/updateimage", [
    "MembersController",
    "UpdateMemberImage",
]);
$router->post("/admin/jobs/add", ["SchedulerController", "AddJob"]);
$router->post("/admin/jobs/modify", ["SchedulerController", "ModifyJob"]);
$router->post("/admin/jobs/delete", ["SchedulerController", "DeleteJob"]);

// Client Part
$router->get("/client/", ["ClientController", "Login"]);
$router->get("/client/home", ["ClientController", "ClientHome"]);
$router->get("/client/dashboard",["ClientController","ClientDashboard"]);
$router->get("/client/verifyclient",['ClientController', 'ClientVerify']);
$router->get("/client/getclients",["ClientController","GetClients"]);

$router->post("/client/auth", ["ClientController", "ClientAuthenticate"]);
$router->post("/client/mailverify",['ClientController', 'MailVerifyClient']);
$router->post("/client/register", ["ClientController", "RegisterClient"]);
$router->post("/client/delete", ["ClientController", "DeleteClient"]);

// Quiz Part 

$router->get("/quiz/home",['QuizController', 'Home']);
$router->get("/quiz/getquizzes",['QuizController', 'GetQuizzes']);
$router->get("/quiz/leaderboard",["QuizController","QuizLeaderBoards"]);

$router->post("/quiz/getquiz",['QuizController', 'GetQuiz']);
$router->post("/quiz/getquizquestions",['QuizController', 'GetQuizQuestions']);
$router->post("/quiz/add", ["QuizController", "AddQuiz"]);
$router->post("/quiz/delete", ["QuizController", "DeleteQuiz"]);
$router->post("/quiz/modify", ["QuizController", "ModifyQuiz"]);
$router->post("/quiz/question/add", ["QuizController", "AddQuizQuestion"]);
$router->post("/quiz/question/delete", ["QuizController", "DeleteQuizQuestion"]);
$router->post("/quiz/question/modify", ["QuizController", "ModifyQuizQuestion"]);

// Quiz Client Part include Leaderboard and QuizClient db update, and also constraints like one time submission and he can give any times but no use, once submit that is final

$router->post("/client/quiz/score",['QuizController', 'UpdateScoreClient']);


$userType = userTypes::Public;
foreach ($router->routes["GET"] as $routes => $actions) {
    if (strpos($routes, $uri) !== false) {
        $userType = userTypes::Admin;
        break;
    }
}
foreach ($router->routes["POST"] as $routes => $actions) {
    if (strpos($routes, $uri) !== false) {
        $userType = userTypes::Admin;
        break;
    }
}
if ($userType === userTypes::Public) {
    $path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $fullPath = Env::BASE_PATH . "/public" . $path;
    if (is_file($fullPath)) {
        $mimeType = mime_content_type($fullPath);
        if (strpos($fullPath, ".css") !== false) {
            header("Content-Type: text/css");
        } else {
            header("Content-Type: $mimeType");
        }
        header("Content-Length: " . filesize($fullPath));
        readfile($fullPath);
        return false;
    } else {
        $indexHtml = Env::BASE_PATH . "/public/index.html";
        if (file_exists($indexHtml)) {
            header("Content-Type: text/html");
            readfile($indexHtml);
            exit();
        }
    }
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $router->routeAction(
            $_SERVER["REQUEST_URI"],
            $_SERVER["REQUEST_METHOD"],
            $_POST,
        );
    } elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
        $router->routeAction(
            $_SERVER["REQUEST_URI"],
            $_SERVER["REQUEST_METHOD"],
        );
    }
}
