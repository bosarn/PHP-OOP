<?php


class LogoutService
{

    private $User;

    public function __construct($User)
    {
        $this->User = $User;
    }

    public function LogoutUser()
    {
        global $_application_folder;
        global $MS;

        session_start();
        $UserService = new UserService();
        $UserService->LogLogoutUser();

        session_destroy();
        unset($_SESSION);

        session_start();
        session_regenerate_id();
        $MS->AddMessage( "U bent afgemeld!" );
        header("Location: " . $_application_folder . "/login.php");
    }

}