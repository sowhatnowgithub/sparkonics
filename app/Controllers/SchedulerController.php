<?php

namespace Sowhatnow\App\Controllers;

use Sowhatnow\App\Controllers\AdminController;
use Sowhatnow\Env;
class SchedulerController extends AdminController
{
    public function SchedulerPage()
    {
        $this->sessionStatusCord("Accesing the scheduler page");
        require Env::BASE_PATH . "/app/Views/Scheduler.php";
    }
}
