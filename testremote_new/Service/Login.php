<?php


class Login
{

    public function CheckLogin()
    {
        //gebruiker opzoeken ahv zijn login (e-mail)
        $sql = "SELECT * FROM users WHERE usr_login='" . $this->login . "' ";
        $data = GetData($sql);
        if ( count($data) == 1 )
        {
            $row = $data[0];
            //password controleren
            if ( password_verify( $this->paswd, $row['usr_paswd'] ) ) $login_ok = true;
        }

        if ( $login_ok )
        {
            session_start();
            $this->Load($row);
            $_SESSION['usr'] = $this;
            $this->LogLoginUser();
            return true;
        }

        return false;
    }

    private function Load( $row )
    {
        $this->id = $row['usr_id'];
        $this->voornaam = $row['usr_voornaam'];
        $this->naam = $row['usr_naam'];
        $this->login = $row['usr_login'];
        $this->paswd = $row['usr_paswd'];
        $this->straat = $row['usr_straat'];
        $this->huisnr = $row['usr_huisnr'];
        $this->busnr = $row['usr_busnr'];
        $this->postcode = $row['usr_postcode'];
        $this->gemeente = $row['usr_gemeente'];
        $this->telefoon = $row['usr_telefoon'];
        $this->pasfoto = $row['usr_pasfoto'];
        $this->vz_eid = $row['usr_vz_eid'];
        $this->az_eid = $row['usr_az_eid'];
    }

    public function LogLoginUser()
    {
        $session = session_id();
        $timenow = new DateTime( 'NOW', new DateTimeZone('Europe/Brussels') );
        $now = $timenow->format('Y-m-d H:i:s') ;
        $sql = "INSERT INTO log_user SET log_usr_id=".$this->id.", log_session_id='".$session."', log_in= '".$now."'";
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