<?php


class UserService
{
    private $User;

//    public function __construct($User)
//    {
//        $this->User = $User;
//    }

//REGISTRATIE
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


//CHECK LOGIN
    public function CheckLogin(User $User)
    {
        //gebruiker opzoeken ahv zijn login (e-mail)
        //$User = new User();
        $sql = "SELECT * FROM users WHERE usr_login='" . $User->getLogin() . "' ";
        $data = GetData($sql);
        if ( count($data) == 1 )
        {
            $row = $data[0];
            //password controleren
            if ( password_verify( $User->getPaswd(), $row['usr_paswd'] ) ) $login_ok = true;
        }

        if ( $login_ok )
        {
            session_start();
            $this->Load( $row );
            $_SESSION['usr'] = $User->getLogin();
            $this->LogLoginUser($User);
            return true;
        }
        return false;
    }


    private function Load( $row )
    {
        $User = new User();
        $User->setId($row['usr_id']);
        $User->setVoornaam($row['usr_voornaam']);
        $User->setNaam($row['usr_naam']);
        $User->setLogin($row['usr_login']);
        $User->setPaswd($row['usr_paswd']);
        $User->setStraat($row['usr_straat']);
        $User->setHuisnr($row['usr_huisnr']);
        $User->setBusnr($row['usr_busnr']);
        $User->setPostcode($row['usr_postcode']);
        $User->setGemeente($row['usr_gemeente']);
        $User->setTelefoon($row['usr_telefoon']);
        $User->setPasfoto($row['usr_pasfoto']);
        $User->setVzEid($row['usr_vz_eid']);
        $User->setAzEid($row['usr_az_eid']);
    }

//LOGIN
    public function PushLogin()
    {
        global $_application_folder;
        global $MS;

        $formname = $_POST["formname"];
        $buttonvalue = $_POST['loginbutton'];

        if ( $formname == "login_form" AND $buttonvalue == "Log in" )
        {
            $User = new User();
            $User->setLogin($_POST['usr_login']);
            $User->setPaswd($_POST['usr_paswd']);


            if ( $this->CheckLogin($User) )
            {
                $MS->AddMessage( "Welkom, " . $User->getVoornaam() . "!" );
                header("Location: " . $_application_folder . "/steden.php");
            }
            else
            {
                $MS->AddMessage( "Sorry! Verkeerde login of wachtwoord!", "error" );
                header("Location: " . $_application_folder . "/login.php");
            }
        }
        else
        {
            $MS->AddMessage( "Sorry! Er ging iets mis.", "error" );
        }
    }

//LOGOUT
    public function LogoutUser()
    {
        global $_application_folder;
        global $MS;

        session_start();
        $this->LogLogoutUser();

        session_destroy();
        unset($_SESSION);

        session_start();
        session_regenerate_id();
        $MS->AddMessage( "U bent afgemeld!" );
        header("Location: " . $_application_folder . "/login.php");
    }

//LOG REGISTRATIE
    public function LogLoginUser(User $User)
    {
        $User = new User();
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$User->getId().", log_session_id='".$session."', log_in= '".$now."'";
        ExecuteSQL($sql);
    }

    public function LogLogoutUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "UPDATE log_user SET  log_out='".$now."' where log_session_id='".$session."'";
        ExecuteSQL($sql);
    }
}