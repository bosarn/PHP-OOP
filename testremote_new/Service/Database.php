<?php


class Database
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function getData( $sql)
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * @param $sql
     * @return bool
     */

    function executeSQL( $sql)
    {
        $stm = $this->pdo->prepare($sql);

        if ($stm->execute()) return true;
        else return false;
    }


}