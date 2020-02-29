<?php


class LogUser
{
    private $logId;
    private $logSessionId;
    private $logInDate;
    private $logOutDate;

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * @param mixed $logId
     */
    public function setLogId($logId)
    {
        $this->logId = $logId;
    }

    /**
     * @return mixed
     */
    public function getLogSessionId()
    {
        return $this->logSessionId;
    }

    /**
     * @param mixed $logSessionId
     */
    public function setLogSessionId($logSessionId)
    {
        $this->logSessionId = $logSessionId;
    }

    /**
     * @return mixed
     */
    public function getLogInDate()
    {
        return $this->logInDate;
    }

    /**
     * @param mixed $logInDate
     */
    public function setLogInDate($logInDate)
    {
        $this->logInDate = $logInDate;
    }

    /**
     * @return mixed
     */
    public function getLogOutDate()
    {
        return $this->logOutDate;
    }

    /**
     * @param mixed $logOutDate
     */
    public function setLogOutDate($logOutDate)
    {
        $this->logOutDate = $logOutDate;
    }



}