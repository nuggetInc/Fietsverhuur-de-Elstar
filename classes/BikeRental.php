<?php 

declare(strict_types=1);

require_once("Database.php");

class BikeRental 
{
    private string $dateFrom;
    private string $dateTo;
    private string $dateNow;

    public function setDate($value)
    {
        $this->dateNow = $value;
    }

    public function getReserved()
    {
        $params = array(':dateNow'=>$this->dateNow);
        $sth = Database::getPDO()->prepare("SELECT * FROM bike_rental WHERE date_from <= :dateNow AND date_to >= :dateNow AND status = 'reserved'");
        $sth->execute($params);
        return $sth->fetchAll();
    }
}

?>