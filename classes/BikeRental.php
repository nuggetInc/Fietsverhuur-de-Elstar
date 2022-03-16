<?php 

declare(strict_types=1);

require_once("Database.php");

class BikeRental 
{
    private string $dateFrom;
    private string $dateTo;
    private string $dateNow;
    private static string $queryString = "AND status = ";
    private string $status;
    
    public function __construct()
    {
        $this->status = BikeRental::$queryString . 1; 
    }

    public function setDate($value) : void
    {
        $this->dateNow = $value;
    }
    /** 
     * enter a number referring to the status:
     * 0=Get all
     * 1=reserved 
     * 2=rented_out
     * 3=returned*/
    public function setStatus($value) : void 
    {
        $this->status = ($value == 0) ? "" : BikeRental::$queryString . $value;
    }

    public function getDate() : array
    {
        $params = array(':dateNow'=>$this->dateNow, ':status'=>$this->status);
        $sth = Database::getPDO()->prepare("SELECT * FROM bike_rental WHERE date_from <= :dateNow AND date_to >= :dateNow :status ORDER BY customer_id ASC");
        $sth->execute($params);
        return $sth->fetchAll();
    }
}

?>