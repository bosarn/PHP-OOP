<?php
class WeekLoader
{

    private $pdo;
    private $week;
    private $year;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->setWeek();
    }

    /**
     * @return PDO
     */
    private function getPDO()
    {
        return $this->pdo;
    }
    public function getYear()
    {
        return $this->year;
    }

    public function getWeek()
    {
        return $this->week;
    }
//
    private function setWeek()
    {
        $this->year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
        $this->week = (isset($_GET['week'])) ? $_GET['week'] : date("W");
        if (isset($_GET['week']) AND $this->week < 10) {
            $this->week = '0' . $this->week;
        }
        if ($this->week > 52) {
            $this->year++;
            $this->week = 1;
        }
        elseif ($this->week < 1) {
            $this->year--;
            $this->week = 52;
        }

    }
// Fetch data for given date
// create object "taken" from data in an array.
    /**
     * @param taken
     * @return Taken[]
     */
    public function SQLDate($datum)
    {
        $takenarray = array();
        $statement = $this->getPDO()->prepare('SELECT * FROM taak WHERE taa_datum = :datum');
        $statement->execute(array('datum' => $datum));
        $WeekArray = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (!$WeekArray) {
            return null;
        }

        foreach ($WeekArray as $taken) {
            $takenarray[] =

            $taak = new Taken();
            $taak->setId($taken['taa_id']);
            $taak->setOmschrijving($taken['taa_omschr']);
            $taak->setDatum($taken['taa_datum']);
        }

        return $takenarray;
    }



// Returns rows for each day in table with Taken object in it.

    /**
     * @param taken
     */
    public function getRow($day)
    {
        $y = $this->year;
        $w = $this->week;

        $date = strtotime($y . "W" . $w . $day);
        $sql = date("Y-m-d", $date);

        $data = $this->SQLDate($sql);

        $taken = array();

        if (isset($data)) foreach ($data as $row) {
            $taken[] = $row->getOmschrijving();
        }

        $takenlijst = "<ul><li>" . implode("</li><li>", $taken) . "</li></ul>";

        echo "<tr>";
        echo "<td>" . date("l", $date) . "</td>";
        echo "<td>" . date("d/m/Y", $date) . "</td>";
        echo "<td>" . $takenlijst . "</td>";
        echo "</tr>";
    }



}

