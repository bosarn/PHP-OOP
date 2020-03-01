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
            $User = new User();
            $this->ValidatePostedUserData($User);
            $this->RegisterUser($User);
        }
    }

    public function ValidatePostedUserData(User $User)
    {
        $this->CheckIfUserExistsAlready($User);

        //controle wachtwoord minimaal 8 tekens
        if ( strlen($_POST["usr_paswd"]) < 8 ) die("Uw wachtwoord moet minstens 8 tekens bevatten!");

        //controle geldig e-mailadres
        if (!filter_var($_POST["usr_login"], FILTER_VALIDATE_EMAIL)) die("Ongeldig email formaat voor login");
    }

    public function CheckIfUserExistsAlready(User $User)
    {
        //controle of gebruiker al bestaat
        $sql = "SELECT * FROM users WHERE usr_login='" . $_POST['usr_login'] . "' ";
        $data = GetData($sql);

        if ( count($data) > 0 ) die("Deze gebruiker bestaat reeds! Gelieve een andere login te gebruiken.");
    }

    public function RegisterUser(User $User)
    {
        global $tablename;
        global $_application_folder;
        global $MS;

        //wachtwoord coderen
        $password_encrypted = password_hash ( $_POST["usr_paswd"] , PASSWORD_DEFAULT );

        $sql = "INSERT INTO $tablename SET " .
            " usr_voornaam='" . htmlentities($_POST['usr_voornaam'], ENT_QUOTES) . "' , " .
            " usr_naam='" . htmlentities($_POST['usr_naam'], ENT_QUOTES) . "' , " .
            " usr_straat='" . htmlentities($_POST['usr_straat'], ENT_QUOTES) . "' , " .
            " usr_huisnr='" . htmlentities($_POST['usr_huisnr'], ENT_QUOTES) . "' , " .
            " usr_busnr='" . htmlentities($_POST['usr_busnr'], ENT_QUOTES) . "' , " .
            " usr_postcode='" . htmlentities($_POST['usr_postcode'], ENT_QUOTES) . "' , " .
            " usr_gemeente='" . htmlentities($_POST['usr_gemeente'], ENT_QUOTES) . "' , " .
            " usr_telefoon='" . htmlentities($_POST['usr_telefoon'], ENT_QUOTES) . "' , " .
            " usr_login='" . $_POST['usr_login'] . "' , " .
            " usr_paswd='" . $password_encrypted . "'  " ;

        if ( ExecuteSQL($sql) )
        {
            $MS->AddMessage( "Bedankt voor uw registratie!" );

            $User->setLogin($_POST['usr_login']);
            $User->setPaswd($_POST['usr_paswd']);

            if ( $this->CheckLogin($User) )
            {
                header("Location: " . $_application_folder . "/steden.php");
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord na registratie!", "error" );
                header("Location: " . $_application_folder . "/login.php");
            }
        }
        else
        {
            $MS->AddMessage( "Sorry, er liep iets fout. Uw gegevens werden niet goed opgeslagen", "error" ) ;
        }
    }
}