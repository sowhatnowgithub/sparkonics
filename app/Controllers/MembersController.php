<?php

namespace Sowhatnow\App\Controllers;
use Sowhatnow\App\Models\MemberModel;
use Sowhatnow\Env;
use Sowhatnow\App\Controllers\AdminController;
class MembersController extends AdminController
{
    protected $url = Env::HOST_ADDRESS;
    protected $adminModel;
    public function __construct()
    {
        $this->adminModel = new MemberModel();
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
    public function RegisterMember($settings)
    {
        $query = "INSERT INTO Members (MemName,
        MemWebMail ,
        MemMobile ,
        MemDegree ,
        MemRollNo ,
        MemPassword ,
        MemPosition , MemAccessGranted, MemImageUrl, MemRole) VALUES ( ";
        $query .= "'{$settings["username"]}'";
        $query .= ",";
        $query .= "'{$settings["usermail"]}'";
        $query .= ",";
        $query .= "'{$settings["userphone"]}'";
        $query .= ",";

        $query .= "'{$settings["userdegree"]}'";
        $query .= ",";

        $query .= "'{$settings["userrollnumber"]}'";
        $query .= ",";

        $query .= "'{$settings["userpassword"]}'";
        $query .= ",";

        $query .= "'{$settings["userposition"]}'";
        $query .= ",";

        $query .= 0;
        $query .= ",";

        $query .= "'/api/images/4901'";
        $query .= ",";
        $query .= "'No Role Given'";
        $query .= " )";
        $response = $this->adminModel->RegisterMember($query);
        if ($response) {
            require Env::BASE_PATH . "/app/Views/successPage.php";
            exit();
        } else {
            echo "Failed to submit";
            exit();
        }
    }
    public function MemberDelete($data)
    {
        $this->sessionStatusCord();

        echo $this->adminModel->DeleteMember($data["MemId"]);
    }
    public function GrantAccessMemeber($data)
    {
        $this->sessionStatusCord();

        echo $this->adminModel->GrantAccessMemeber($data);
    }
    public function MembersControl()
    {
        $this->sessionStatusCord();
        $membersData = $this->adminModel->FetchMembers();
        $url = Env::HOST_ADDRESS;
        require Env::BASE_PATH . "/app/Views/MembersControl.php";
    }
    public function UpdateMemberRole($data)
    {
        $this->sessionStatusCord();
        echo $this->adminModel->UpdateMemberRole($data);
    }
    public function UpdateMemberImage($data)
    {
        $this->sessionStatus();
        var_dump($data);
        echo $this->adminModel->UpdateMemberImage($data);
    }
}
