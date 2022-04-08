<?php 

declare(strict_types=1);

require_once("Database.php");

class BikeRental 
{
    private string $dateFrom;
    private string $dateTo;
    private int $numberOfPeople;
    private int $customerId;
    private int $childSeat;
    private string $comment;
    private string $dateNow;
    private static string $queryString = "AND status = ";
    private string $status;
    
    public function __construct()
    {
        $this->status = BikeRental::$queryString . 1; 
    }
    
    public function setDates(array $value) : void
    {
        $this->dateFrom = $value["dateFrom"];
        $this->dateTo = $value["dateTo"];
    }
    public function setNumberOfPeople($value) : void
    {
        $this->numberOfPeople = intval($value);
    }
    public function setCustomerId($value) : void
    {
        $this->customerId = intval($value);
    }
    public function setChildSeat($value) : void
    {
        $this->childSeat = $value;
    }
    public function setComment($value) : void
    {
        $this->comment = $value;
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
    /** 
     * Adds to BikeRental table.
     * Param = $_SESSION["user"]
    */
    public function addReserve($user)
    {
        $params = array(':date_from'=>$this->dateFrom, ':date_to'=>$this->dateTo, 
        ':employee_name'=>$user, 'customer_id'=>$this->customerId, ':framenumber'=>"", 
        ':child_seat'=>$this->childSeat, ':comment'=>$this->comment);
        $sth = Database::getPDO()->prepare("INSERT INTO bike_rental (employee_name, customer_id, framenumber, date_from, date_to, child_seat, status, comment)
        VALUES (:employee_name, :customer_id, :framenumber, :date_from, :date_to, :child_seat, 'reserved', :comment)");
        for($i = 0; $i < $this->numberOfPeople; $i++)
        {
            $sth->execute($params);
        }
    }
}

?>