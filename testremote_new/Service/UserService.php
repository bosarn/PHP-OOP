<?php


class UserService
{

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