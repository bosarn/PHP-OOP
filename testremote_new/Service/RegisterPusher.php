<?php


class RegisterPusher
{
    private $User;

    public function __construct($User)
    {
        $this->User = $User;
    }

    public function PushRegister()
    {
        $formname = $_POST["formname"];

        if ($formname == "registration_form" AND $_POST['register-but'] == "Register") {
            $UserService = new UserService();
            $User = new User();
            $UserService->ValidatePostedUserData($User);
            $UserService->RegisterUser($User);
        }
    }
}